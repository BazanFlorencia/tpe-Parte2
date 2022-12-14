<?php

class ProductsApiModel{

    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=Localhost;'.'dbname=db_productos;charset=utf8','root','');
    }

    public function getColumnsOfTable(){
        $query = $this -> db -> prepare("SHOW COLUMNS FROM lista_productos");
        $query -> execute();
        $columns = $query -> fetchAll(PDO::FETCH_OBJ);
        return $columns;
    }
    public function getNumColumns($columns){
        $query = $this -> db -> prepare('SELECT count(*) as quantity FROM ?');
        $query -> execute([$columns]);
        $quantity = $query -> fetchObject()->quantity;
        return $quantity;
    }

    //MOSTRAR TODOS LOS PRODUCTOS
    public function getAll(){
        $query = $this -> db -> prepare('SELECT lista_productos.*, categorias.tipo_producto as categoria FROM lista_productos INNER JOIN categorias ON lista_productos.id_categoria=categorias.id_categoria');
        $query -> execute();
        $products = $query -> fetchAll(PDO::FETCH_OBJ);

        return $products;
    }

    //MOSTRAR UN PRODUCTO
    public function get($id){
        $query = $this->db -> prepare('SELECT lista_productos.*, categorias.tipo_producto as categoria FROM lista_productos INNER JOIN categorias ON lista_productos.id_categoria=categorias.id_categoria WHERE id_producto=?');
        $query->execute([$id]);
        $product = $query ->fetch(PDO::FETCH_OBJ);
        return $product;
    }

    //INSERTAR UN PRODUCTO
    public function insert($name, $price, $type_product){
        $query = $this-> db -> prepare("INSERT INTO lista_productos (nombre_producto, precio, id_categoria) VALUES (?,?,?)");
        $query->execute([$name, $price, $type_product]);
        return $this->db->lastInsertId();
    }

    //ORDENAR ASCENDENTE POR COLUMNA
    public function getOrderedByColumn($sort = null){
        $query =  $this->db->prepare("SELECT lista_productos.* , categorias.tipo_producto as categoria FROM lista_productos INNER JOIN categorias ON lista_productos.id_categoria=categorias.id_categoria  ORDER BY $sort");
        $query->execute();
        $products = $query ->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    //FILTRAR 
    public function getProductsFiltered($search = null){
        $query = $this -> db -> prepare('SELECT lista_productos.*, categorias.tipo_producto as categoria FROM lista_productos INNER JOIN categorias ON lista_productos.id_categoria=categorias.id_categoria WHERE nombre_producto LIKE ? OR precio LIKE ? OR categorias.tipo_producto LIKE ?');
        $query -> execute(["%$search%","%$search%", "%$search%"]);
        $products = $query ->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    //MOSTRAR CANTIDAD DE PRODUCTOS
    public function getQuantityProducts(){
        $query = $this -> db -> prepare('SELECT count(*) as quantity FROM lista_productos');
        $query->execute();
        $quantity = $query -> fetchObject()->quantity;
        return $quantity;
    }

    //PAGINACION 
    public function productsByPage($page = null, $limit = null){
        $offset = ($page - 1) * $limit;
        $query = $this->db->prepare("SELECT * FROM lista_productos LIMIT $limit OFFSET $offset");
        $query->execute([]);
        $productsByPage = $query -> fetchAll(PDO::FETCH_OBJ);
        return $productsByPage;
    }

    //PRODUCTOS FILTRADOS ORDENADOS ASCENDENTE POR COLUMNA 
    public function getOrderedAndFiltered($sort = null, $search = null){
        $query = $this -> db -> prepare("SELECT lista_productos.*, categorias.tipo_producto as categoria FROM lista_productos INNER JOIN categorias ON lista_productos.id_categoria=categorias.id_categoria WHERE nombre_producto LIKE ? OR categorias.tipo_producto LIKE ? ORDER BY  $sort");
        $query -> execute(["%$search%", "%$search%"]);
        $products = $query ->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    //PRODUCTOS PAGINADOS CON LIMITE ORDENADOS ASCENDENTE POR COLUMNA
    public function getOrderedAndPaginatedWithLimit($sort = null, $page = null, $limit = null){
        $offset = ($page - 1) * $limit;
        $query = $this->db->prepare("SELECT lista_productos.* , categorias.tipo_producto as categoria FROM lista_productos INNER JOIN categorias ON lista_productos.id_categoria=categorias.id_categoria ORDER BY $sort LIMIT $limit OFFSET $offset");
        $query->execute([]);
        $productsByPage = $query -> fetchAll(PDO::FETCH_OBJ);
        return $productsByPage;
    }

    //PRODUCTOS FILTRADOS Y PAGINADOS
    public function getFilteredAndPaginated($search = null, $page = null){
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $query = $this -> db -> prepare("SELECT lista_productos.*, categorias.tipo_producto as categoria FROM lista_productos INNER JOIN categorias 
                                        ON lista_productos.id_categoria=categorias.id_categoria 
                                        WHERE nombre_producto LIKE ? OR precio LIKE ? OR categorias.tipo_producto LIKE ? LIMIT $limit OFFSET $offset");
        $query -> execute(["%$search%","%$search%", "%$search%"]);
        $products = $query ->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    //PRODUCTOS FILTRADOS PAGINADOS CON LIMITE
    public function getFilteredAndPaginatedWithLimit($search = null, $page = null, $limit = null){
        $offset = ($page - 1) * $limit;
        $query = $this -> db -> prepare("SELECT lista_productos.*, categorias.tipo_producto as categoria FROM lista_productos INNER JOIN categorias 
                                        ON lista_productos.id_categoria=categorias.id_categoria 
                                        WHERE nombre_producto LIKE ? OR precio LIKE ? OR categorias.tipo_producto LIKE ? LIMIT $limit OFFSET $offset");
        $query -> execute(["%$search%","%$search%", "%$search%"]);
        $products = $query ->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    //PRODUCTOS FILTRADOS, PAGINADOS Y ORDENADOS ASCENDENTE POR COLUMNA
    public function getProductsFilteredPaginatedAndOrdered($page = null, $search = null, $sort = null){
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $query= $this->db->prepare("SELECT * FROM lista_productos WHERE nombre_producto LIKE ? OR precio LIKE ? ORDER BY $sort LIMIT $limit OFFSET $offset");
        $query -> execute(["%$search%","%$search%"]);
        $products = $query ->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }
    
    //PRODUCTOS FILTRADOS, PAGINADOS CON LIMITE Y ORDENADOS ASCENDENTE POR COLUMNA
    public function getFilteredPaginatedWithLimitAndOrdered($page = null, $search = null, $sort = null, $limit = null){
        $offset = ($page - 1) * $limit;
        $query= $this->db->prepare("SELECT * FROM lista_productos WHERE nombre_producto LIKE ? OR precio LIKE ? ORDER BY $sort LIMIT $limit OFFSET $offset");
        $query -> execute(["%$search%","%$search%"]);
        $products = $query ->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    //ELIMINAR PRODUCTO
    function delete($id) {
        $query = $this->db->prepare('DELETE FROM lista_productos WHERE id = ?');
        $query->execute([$id]);
    }
}
