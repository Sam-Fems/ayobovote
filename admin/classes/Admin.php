<?php
require_once dirname(__DIR__, 2) . '/classes/config.php';
require_once dirname(__DIR__, 2) . '/classes/Db.php';

class Admin extends Db
{
    private $ayconn;

    public function __construct()
    {
        $this->ayconn = $this->connect();
    }

    private function generateVoterID()
    {
        return 'AYB' . date('Y') . rand(1000, 9999);
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM admins WHERE username = :username";
        $stmt = $this->ayconn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            return true;
        }

        return false;
    }

    public function add_candidate($name, $party, $position)
    {
        try {
            $sql = "INSERT INTO candidates (name, party, position) VALUES (:name, :party, :position)";
            $stmt = $this->ayconn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':party', $party);
            $stmt->bindParam(':position', $position);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Add candidate error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllCandidates()
    {
        $stmt = $this->ayconn->prepare("
        SELECT 
            c.id, c.name, c.position, c.party, c.created_at,
            COALESCE(COUNT(v.id), 0) as vote_count
        FROM candidates c
        LEFT JOIN votes v ON c.id = v.candidate_id
        GROUP BY c.id
        ORDER BY c.created_at ASC   -- or whatever order you want
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function deleteCandidate($id)
    {
        try {
            // Step 1: Check if this candidate has any votes
            $check = $this->ayconn->prepare("
            SELECT COUNT(*) as vote_count 
            FROM votes 
            WHERE candidate_id = ?
        ");
            $check->execute([$id]);
            $result = $check->fetch(PDO::FETCH_ASSOC);

            if ($result['vote_count'] > 0) {
                // Cannot delete — has votes
                return [
                    'success' => false,
                    'message' => 'Cannot delete this candidate because they have received votes.'
                ];
            }

            // Step 2: Safe to delete — no votes yet
            $stmt = $this->ayconn->prepare("DELETE FROM candidates WHERE id = ?");
            $stmt->execute([$id]);

            $deleted = $stmt->rowCount() > 0;

            if ($deleted) {
                return [
                    'success' => true,
                    'message' => 'Candidate deleted successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Candidate not found or already deleted'
                ];
            }
        } catch (PDOException $e) {
            error_log("Delete candidate error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error occurred'
            ];
        }
    }

    public function add_voter($full_name, $phone, $email, $password)
    {
        try {
            // Check if email already exists
            $check = $this->ayconn->prepare("SELECT id FROM voters WHERE email = ?");
            $check->execute([$email]);
            if ($check->rowCount() > 0) {
                return [
                    'success' => false,
                    'message' => 'This email is already registered'
                ];
            }

            // Check if phone already exists
            $check = $this->ayconn->prepare("SELECT id FROM voters WHERE phone = ?");
            $check->execute([$phone]);
            if ($check->rowCount() > 0) {
                return [
                    'success' => false,
                    'message' => 'This phone number is already registered'
                ];
            }

            // Generate voter ID
            $voterId = $this->generateVoterID();

            // Hash password
            $hashed = password_hash($password, PASSWORD_BCRYPT);

            // Insert new voter
            $sql = "INSERT INTO voters (voter_id, full_name, phone, email, password, created_at)
                VALUES (:voter_id, :full_name, :phone, :email, :password, NOW())";

            $stmt = $this->ayconn->prepare($sql);
            $stmt->execute([
                ':voter_id'   => $voterId,
                ':full_name'  => $full_name,
                ':phone'      => $phone,
                ':email'      => $email,
                ':password'   => $hashed
            ]);

            return [
                'success'  => true,
                'voter_id' => $voterId,
                'message'  => 'Voter registered successfully'
            ];
        } catch (PDOException $e) {
            error_log("Add voter error: " . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        } catch (Exception $e) {
            error_log("Unexpected error in add_voter: " . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Unexpected error occurred'
            ];
        }
    }

    public function deleteVoter($id)
    {
        try {
            $stmt = $this->ayconn->prepare("DELETE FROM voters WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Delete voter error: " . $e->getMessage());
            return false;
        }
    }

    // Get all voters
    public function getAllVoters()
    {
        $stmt = $this->ayconn->prepare("SELECT * FROM voters ORDER BY created_at ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch_votes()
    {
        try {
            $sql = "SELECT 
                    v.id,
                    v.voter_id,
                    v.candidate_id,
                    v.voted_at AS vote_time,
                    c.name,
                    c.party
                FROM votes v
                LEFT JOIN candidates c ON v.candidate_id = c.id
                LEFT JOIN voters ON v.voter_id = voters.voter_id
                ORDER BY v.voted_at DESC
            ";

            $stmt = $this->ayconn->prepare($sql);
            $stmt->execute();

            $votes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'data'    => $votes,
                'total'   => count($votes)
            ];
        } catch (PDOException $e) {

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    // In your Voter.php or Results.php class
    public function getElectionResults()
    {
        try {
            $stmt = $this->ayconn->prepare("
            SELECT 
                c.id,
                c.name,
                c.party,
                COALESCE(SUM(CASE WHEN v.candidate_id = c.id THEN 1 ELSE 0 END), 0) AS votes
            FROM candidates c
            LEFT JOIN votes v ON c.id = v.candidate_id
            GROUP BY c.id
            ORDER BY votes DESC
        ");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $total = array_sum(array_column($rows, 'votes'));

            // Calculate percentages
            foreach ($rows as &$row) {
                $row['percentage'] = $total > 0 ? round(($row['votes'] / $total) * 100, 1) : 0;
            }

            return $rows;
        } catch (Exception $e) {
            error_log("Results error: " . $e->getMessage());
            return [];
        }
    }

    public function getVotersForCandidate($candidate_id)
    {
        $stmt = $this->ayconn->prepare("
        SELECT v.full_name
        FROM votes vt
        JOIN voters v ON vt.voter_id = v.id
        WHERE vt.candidate_id = ?
        ORDER BY v.full_name ASC
    ");
        $stmt->execute([$candidate_id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function startVotingSession($admin_id)
    {
        try {
            $stmt = $this->ayconn->prepare("
            UPDATE voting_status 
            SET 
                is_active = 1,
                ended_at = NULL,
                ended_by_admin_id = NULL
            WHERE id = 1
        ");

            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Start voting session error: " . $e->getMessage());
            return false;
        }
    }

    public function endVotingSession($admin_id)
    {
        try {
            $stmt = $this->ayconn->prepare("
            UPDATE voting_status 
            SET 
                is_active = 0, 
                ended_at = NOW(), 
                ended_by_admin_id = ?
            WHERE id = 1
        ");

            $stmt->execute([$admin_id]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("End voting session error: " . $e->getMessage());
            return false;
        }
    }

    public function getElectionStatus()
    {
        try {
            $stmt = $this->ayconn->prepare("
            SELECT 
                is_active,
                ended_at,
                ended_by_admin_id,
                updated_at
            FROM voting_status 
            WHERE id = 1
            LIMIT 1
        ");

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return [
                    'is_active'         => true,
                    'ended_at'          => null,
                    'ended_by_admin_id' => null,
                    'updated_at'        => null,
                    'message'           => 'No status record found - voting assumed open'
                ];
            }

            return [
                'is_active'         => (bool) $row['is_active'],
                'ended_at'          => $row['ended_at'],
                'ended_by_admin_id' => $row['ended_by_admin_id'] ? (int)$row['ended_by_admin_id'] : null,
                'updated_at'        => $row['updated_at'],
                'message'           => $row['is_active']
                    ? 'Voting is currently OPEN'
                    : 'Voting has been CLOSED'
            ];
        } catch (PDOException $e) {
            error_log("Election status error: " . $e->getMessage());

            return [
                'is_active'         => true,
                'ended_at'          => null,
                'ended_by_admin_id' => null,
                'updated_at'        => null,
                'message'           => 'Unable to check status due to database error - voting assumed open'
            ];
        }
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['admin_id']);
    }

    public function logout()
    {
        unset($_SESSION['admin_id']);
        return ['success' => true];
    }
}
