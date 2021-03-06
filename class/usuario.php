<?php

class Usuario {
    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

        public function getIdusuario() {
            return $this->idusuario;
        }

        public function setIdusuario($value) {
            $this->idusuario = $value;
        }

        public function getDeslogin(){
            return $this->deslogin;
        }

        public function setDeslogin($value) {
            $this->deslogin = $value;
        }

        public function getDessenha(){
            return $this->dessenha;
        }

        public function setDessenha($value){
            $this->dessenha = $value;
        }

        public function getDtcadastro(){
            return $this->dtcadastro;
        }

        public function setDtcadastro($value){
            $this->dtcadastro = $value;
        }

    public function loadById($id) { //Tras a informação da pessoa passando o parametro

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuario WHERE idusuario = :ID", array(
            ":ID"=>$id
        ));

        if(count($results) > 0) {

            $row = $results[0];

            $this->setData($results[0]);
        }
    }

    public static function getList() { //Retorna uma lista ordenada por deslogin
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuario ORDER BY deslogin;");
    }

    public static function search($login) { //Retorna valores de usuarios juntamente com o que foi passado no parâmetro
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuario WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            ':SEARCH'=>"%".$login."%"
        ));
    }

    public function login($login, $password) { //Carrega um usuário por login e senha 
        
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuario WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
            ":LOGIN"=>$login,
            ":PASSWORD"=>$password
        ));

        if(count($results) > 0) {
            
            $this->setData($results[0]);

        } else {

            throw new Exception("Login e/ou senha inválidos.");

        }
    }

    public function setData($data) {
        $this->setIdusuario($data['idusuario']);
        $this->setDeslogin($data['deslogin']);
        $this->setDessenha($data['dessenha']);
        $this->setDtcadastro(new DateTime($data['dtcadastro']));
    }

    public function insert() { //Método para realização de inserção
        $sql = new Sql();

        $results = $sql->select("CALL sp_usuario_insert(:LOGIN, :PASSWORD)", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDessenha()
        ));

        if(count($results) > 0) {
            $this->setData($results[0]);
        }
    }

    public function update($login, $password) { //Método para realização de atualização
        $this->setDeslogin($login);
        $this->setDessenha($password);

        $sql = new Sql();

        $sql->query("UPDATE tb_usuario SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDessenha(),
            ':ID'=>$this->getIdusuario()
        ));
    }

    public function delete() { //Método para realização de deleção
        $sql = new Sql();

        //para apagar do banco
        $sql->query("DELETE FROM tb_usuario WHERE idusuario = :ID", array(
            ':ID'=>$this->getIdusuario()
        ));

        //Para refletir tambem no objeto
        $this->setIdusuario(0);
        $this->setDeslogin("");
        $this->setDessenha("");
        $this->setDtcadastro(new DateTime());
    }

    public function __construct($login = "", $password = "") {
        $this->setDeslogin($login);
        $this->setDessenha($password);
    }

    public function __toString() {
        return json_encode(array(
            "idusuario"=>$this->getIdusuario(),
            "deslogin"=>$this->getDeslogin(),
            "dessenha"=>$this->getDessenha(),
            "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
        ));
    }
}

?>