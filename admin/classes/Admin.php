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

    public function fetch_voters()
    {
        try {
            $sql = "SELECT id, voter_id, full_name, phone, email, password, created_at FROM voters ORDER BY full_name ASC ";

            $stmt = $this->ayconn->prepare($sql);
            $stmt->execute();
            
            $voters = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'success' => true,
                'data'    => $voters,
                'count'   => count($voters)
            ];
        } 
        catch (PDOException $e) {
            error_log("Fetch voters error: " . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Unable to fetch voters at the moment',
                'error'   => $e->getMessage()  
            ];
        }
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
        } 
        catch (PDOException $e) {
            
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function fetch_candidates()
    {
        try {
            $sql = "SELECT 
                    id,
                    name,
                    party,
                    position, 
                    created_at
                FROM candidates
                ORDER BY name ASC
            ";

            $stmt = $this->ayconn->prepare($sql);
            $stmt->execute();
            
            $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'success' => true,
                'data'    => $candidates,
                'total'   => count($candidates)
            ];
        } 
        catch (PDOException $e) {
            error_log("Fetch candidates error: " . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Unable to fetch candidates at the moment'
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
        return true;
    }
}
