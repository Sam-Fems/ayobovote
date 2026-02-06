<?php
require_once 'Db.php';

class Candidate extends Db
{
    private $ayconn;

    public function __construct()
    {
        $this->ayconn = $this->connect();
    }

    public function show_candidates()
    {
        try {
            $sql = "SELECT id, name, position, party, image FROM candidates ORDER BY name ASC";
            $stmt = $this->ayconn->prepare($sql);
            $stmt->execute();
            $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'candidates' => $candidates
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
