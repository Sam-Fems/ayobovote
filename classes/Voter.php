<?php
require_once 'Db.php';

class Voter extends Db
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

    public function register_voter($fullname, $email, $phone, $address, $password)
    {
        try {
            // Check email
            $check = $this->ayconn->prepare(
                "SELECT id FROM voters WHERE email = ?"
            );
            $check->execute([$email]);
            if ($check->rowCount() > 0) {
                return [
                    'success' => false,
                    'message' => 'Email already registered'
                ];
            }

            $check = $this->ayconn->prepare(
                "SELECT id FROM voters WHERE phone = ?"
            );
            $check->execute([$phone]);

            if ($check->rowCount() > 0) {
                return [
                    'success' => false,
                    'message' => 'Phone number already registered'
                ];
            }

            $voterId = $this->generateVoterID();
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO voters
                    (voter_id, full_name, email, phone, address, password, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, NOW())";

            $stmt = $this->ayconn->prepare($sql);
            $stmt->execute([
                $voterId,
                $fullname,
                $email,
                $phone,
                $address,
                $hashed
            ]);

            return [
                'success' => true,
                'voter_id' => $voterId
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function login_voter($voter_id, $password)
    {
        try {
            $sql = "SELECT id, voter_id, full_name, email, password 
                FROM voters 
                WHERE voter_id = ? 
                LIMIT 1";

            $stmt = $this->ayconn->prepare($sql);
            $stmt->execute([$voter_id]);

            if ($stmt->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'Invalid Voter ID or Password'
                ];
            }

            $voter = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!password_verify($password, $voter['password'])) {
                return [
                    'success' => false,
                    'message' => 'Invalid Voter ID or Password'
                ];
            }

            return [
                'success' => true,
                'voter' => [
                    'id' => $voter['id'],
                    'voter_id' => $voter['voter_id'],
                    'fullname' => $voter['full_name'],
                    'email' => $voter['email']
                ]
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'An error occurred during login'
            ];
        }
    }

    public function cast_vote($voter_id, $candidate_id)
    {
        try {
            $this->ayconn->beginTransaction();

            // 1. Check if voter exists and has not voted
            $check = $this->ayconn->prepare(
                "SELECT has_voted FROM voters WHERE id = ?"
            );
            $check->execute([$voter_id]);

            if ($check->rowCount() === 0) {
                $this->ayconn->rollBack();
                return ['success' => false, 'message' => 'Invalid voter'];
            }

            $voter = $check->fetch(PDO::FETCH_ASSOC);

            if ((int)$voter['has_voted'] === 1) {
                $this->ayconn->rollBack();
                return ['success' => false, 'message' => 'You have already voted'];
            }

            // 2. Record the vote
            $vote = $this->ayconn->prepare(
                "INSERT INTO votes (voter_id, candidate_id) VALUES (?, ?)"
            );
            $vote->execute([$voter_id, $candidate_id]);

            // 3. Mark voter as having voted
            $updateVoter = $this->ayconn->prepare(
                "UPDATE voters SET has_voted = 1 WHERE id = ?"
            );
            $updateVoter->execute([$voter_id]);

            // 4. Increment candidate vote count
            $updateCandidate = $this->ayconn->prepare(
                "UPDATE candidates SET vote_count = vote_count + 1 WHERE id = ?"
            );
            $updateCandidate->execute([$candidate_id]);

            $this->ayconn->commit();

            return ['success' => true, 'message' => 'Vote submitted successfully'];
        } catch (PDOException $e) {
            $this->ayconn->rollBack();
            error_log("Vote error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error submitting vote: ' . $e->getMessage()];
        }
    }

    public function getElectionResults()
    {
        try {
            $stmt = $this->ayconn->prepare("
            SELECT 
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

    public function logout()
    {
        // Clear auth data only
        unset($_SESSION['voter_logged_in']);
        unset($_SESSION['voter_db_id']);
        unset($_SESSION['voter_id']);
        unset($_SESSION['voter_name']);
        unset($_SESSION['voter_email']);

        return ['success' => true];
    }
}
