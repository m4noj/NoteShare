<?php 
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct(){
        $host = 'localhost';
        $dbname = 'notes';
        $username = 'root';
        $password = '';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$username,$password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database Connection failed : ". $e->getMessage());
        }
        
    }

    public static function getInstance() {
        if(!self::$instance){
            self::$instance = new Database(); }
        return self::$instance;
    }

    public function query($sql, $args = [], $fetchAll = true){
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        if(strpos($sql, 'SELECT') !== false ) {
            return $fetchAll ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC); }
        return $stmt; 

    }

    public function insert(string $table,array $data){
        $columns = implode(", ",array_keys($data));
        $placeholders = ":" . implode(", :",array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->query($sql,$data);
    }

    public function select(string $table,array $conditions = [],$columns = '*', $fetchAll = true){
        $sql = "SELECT $columns FROM $table";
        if(!empty($conditions)){
            $where = [];
            foreach($conditions as $k => $v){
                $where[] = "$k = :$k"; }
            if(!empty($where)){
                $sql .= " WHERE " . implode(" AND ",$where); } }
        return $this->query($sql,$conditions,$fetchAll);

    }

    public function update(string $table, array $data, array $conditions){
        $updateFields = [];
        foreach ($data as $k => $v) {
            $updateFields[]="$k = :$k"; }
        $where=[];
        foreach ($conditions as $k => $v) {
            $where[]="$k = :where_$k"; }
        $sql = "UPDATE $table SET ". implode(", ",$updateFields). " WHERE ". implode(" AND ",$where);
        $stmt = $this->pdo->prepare($sql);
        foreach ($conditions as $k => $v) {
            $data["where_$k"] = $v; }
        return $this->query($sql,$data);

    }

    public function delete(string $table,array $conditions){
        $where = [];
        foreach ($conditions as $k => $v) {
            $where[]="$k = :$k"; }
        $sql = "DELETE FROM $table WHERE ".implode(" AND ",$where);
        $stmt = $this->pdo->prepare($sql);
        return $this->query($sql,$conditions);

    }

    public function selectOne(string $table, array $conditions = [], $columns = '*'){
        return $this->select($table,$conditions,$columns,false);
    }

    public function count(string $table,array $conditions = []){
        $sql = "SELECT COUNT(*) as count FROM $table";
        if(!empty($conditions)){
            $where = [];
            foreach($conditions as $k => $v){
                $where[] = "$k = :$k"; }
                $sql .= " WHERE " . implode(" AND ",$where); }
            $result = $this->query($sql,$conditions,false);
            return $result ? $result['count'] : 0;
    }

    public function search($table, $columns, $keyword, $orderBy = '', $limit = 10, $offset = 0) {
        $likeClauses = [];
        $params = [];

        foreach ($columns as $column) {
            $likeClauses[] = "$column LIKE ?";
            $params[] = "%$keyword%";
        }

        $sql = "SELECT * FROM $table WHERE " . implode(" OR ", $likeClauses);
        
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }

        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        return $this->query($sql, $params);
    }

    public function sort($table, $orderBy, $limit = 10, $offset = 0) {
        $sql = "SELECT * FROM $table ORDER BY $orderBy LIMIT ? OFFSET ?";
        return $this->query($sql, [$limit, $offset]);
 
}

}

?>