API REST full
    
Desarrollo de Api sencilla para mostrar, agregar y eliminar un producto de una lista de productos de dietética

PARA IMPLEMENTAR LA API, IMPORTAR LA BASE DE DATOS

    Importar la base de datos presente en el archivo TPE-PARTE2/database/db_productos.sql

PRUEBA CON POSTMAN PARA COMPROBAR SU FUNCIONAMIENTO

    El endpoint de la API es: http://localhost/web2/tpe-Parte2/api/products

ENDPOINTS

    Se coloca entre llaves lo que se debe reemplazar por un valor determinado (las llaves son sólo para separar esos términos, deben quitarse).

- APLICACIONES DEL GET 

    Obtener todos los productos de la base de datos: 
        Url: api/products
        Método: GET
        Body:

    Obtener un producto de la base de datos dado un id: 
        Url: api/products/#id
        Método: GET
        Body:

    Obtener los productos de la base de datos ordenados por columna de manera ascendente (se utilizó el ordenamiento ascendente que se establece por defecto): 
        Url: api/products?sort={nombre de columna}
        Método: GET
        Body:

    Obtener los productos filtrados por un parámetro determinado: 
        Url: api/products?search={parámetro}
        Método: GET
        Body:       
    Obtener los productos paginados estableciendo una cantidad determinada de productos por vista por defecto: 
        Url: api/products?page={número de página}
        Método: GET
        Body:

    Obtener los productos paginados pudiendo establecer el límite de cuántos productos ver por página (limit):
        Url: api/products?page={número de página}&limit={cantidad de productos por página}
        Método: GET
        Body:

    Obtener los productos filtrados y paginados: 
        Url: api/products?page={número de página}&search={parámetro de búsqueda}
        Método: GET
        Body:

    Obtener los productos filtrados y paginados con el limite: 
        Url: api/products?page={número de página}&limit={cantidad de productos por página}&search={parámetro de búsqueda}
        Método: GET
        Body:

    Obtener los productos filtrados ordenados por defecto ascendentes: 
        Url: api/products?sort={nombre de columna}&search={parámetro de búsqueda}
        Método: GET
        Body:

    Obtener los productos ordenados por defecto ascendentes y paginados: 
        Url: api/products?page={número de página}&sort={nombre de columna}
        Método: GET
        Body:

    Obtener los productos ordenados por defecto ascendentes y paginados con el limite: 
        Url: api/products?page={número de página}&sort={nombre de columna}&limit={cantidad de productos por página}
        Método: GET
        Body:

- APLICACIONES DEL POST

    Agregar productos a la base de datos: 
        Url: api/products
        Método: POST
        Body:
            {
                "nombre_producto": "Canela molida x 100 grs",
                "precio": 193,
                "id_categoria": 2
            }

- APLICACIONES DEL DELETE

    Eliminar un producto de la base de datos dado un id: 
        Url: api/products/#id
        Método: DELETE
        Body:

MANEJO DE ERRORES (RESPONSE)

Status: 200 OK
        - Procedimientos realizados correctamente en la API. 
        - Los parámetros ingresados son correctos .
        - La respuesta a la consulta de la base de datos es correcta.

Status: 201 Created
        - Correcta incorporación de un producto a la base de datos.

Status: 400 Bad request 
        En el caso de los GET a: 
        - Introducción de un String en lugar de un número.
        - El valor de los parámetros para la paginación, filtrado y ordenado es nulo.

Status: 404 Not found
        - En el caso del filtrado, el parámetro ingresado con pudo ser encontrado.
        - Al hacer el llamado a la base de datos para mostrar un producto en particular, en el caso en que el id buscado no exista en la base de datos.
        - El caso en que al hacer la consulta a la base de datos devuelva un arreglo de elementos vacío.

Status: 500 Internal Server Error
        - Al hacer manejo de excepciones en la aplicación del GET, para hacer la consulta por productos en la base de datos.