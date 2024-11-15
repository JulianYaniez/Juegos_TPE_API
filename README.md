# TPE - Parte 3: API REST de Juegos

## Descripción General

Nuestra API REST ofrece servicios relacionados con la gestión de una base de datos de juegos. Los endpoints permiten listar, agregar, modificar y filtrar juegos.

***Endpoints Disponibles***

- ('juegos', 'GET', 'gamesController', 'getGames');
- ('juegos/:id', 'GET', 'gamesController', 'getGames');
- ('juegos/:id', 'DELETE', 'gamesController', 'deleteGame');
- ('juegos', 'POST', 'gamesController', 'createGame');
- ('juegos/:id', 'PUT', 'gamesController', 'updateGame');
- ('usuarios/token', 'GET', 'authController', 'getToken');

### **1. Listar Todos los Juegos**
- **Método**: `GET`
- **URL**: `/api/juegos`
- **Descripción**: Devuelve una lista de todos los juegos disponibles.
- **Query Params**:
  - `ordenarPor` (opcional): Campo por el cual ordenar. Valores: `titulo`, `genero`, `id_distribuidora`, `precio`, `fecha_salida`.
  - `orden` (opcional): Orden (`ASC` o `DESC`). Por defecto: `ASC`.
  - `pagina` (opcional): Página de resultados. Debe ser un número entero arriba de 0.
  - `limite` (opcional): Cantidad de elementos a mostrar por página. Debe ser un número entero arriba de 0.
  - `criterio`(opcional filtro): Criterio por el cual filtrar, incompatible con queryParams anteriores. Valores:`distribuidora` y precio(`mayor`, `menor`, `igual`).
  - `valor` (opcional filtro): Valor para el criterio de filtro, compatible solo con el queryParam `criterio`.

**Ejemplos**:
GET /api/juegos?ordenarPor=titulo&orden=ASC&pagina=1&limite=2
GET /api/juegos?criterio=distribuidora&valor=1
GET /api/juegos?criterio=mayor&valor=25

---

### **2. Obtener Juego por ID**
- **Método**: `GET`
- **URL**: `/api/juegos/{id}`
- **Descripción**: Devuelve un juego específico por su ID.

**Ejemplo**:
GET /api/juegos/1

---

### **3. Agregar un Juego**
- **Método**: `POST`
- **URL**: `/api/juegos`
- **Descripción**: Agrega un nuevo juego.
- **Body** (JSON):
  ```json
  {
    "titulo": "Nuevo Juego",
    "genero": "Accion",
    "id_distribuidora": 1,
    "precio": 29.99,
    "fecha_salida": "2024"
  }

**Ejemplo**:
POST /api/juegos

---

### **4. Modificar un Juego**
- **Método**: PUT
- **URL**: /api/juegos/{id}
- **Descripción**: Modifica los datos de un juego existente por su ID.
- **Body** (JSON):
  ```json
  {
    "titulo": "Juego Modificado",
    "genero": "Aventura",
    "id_distribuidora": 2,
    "precio": 35.99,
    "fecha_salida": "2015"
  }

**Ejemplo**:
PUT /api/juegos/1

---

### **5. Eliminar un Juego**
- **Método**: DELETE
- **URL**: /api/juegos/{id}
- **Descripción**: Elimina un juego existente por su ID.

**Ejemplo**:
DELETE /api/juegos/1

---

 ### **6. Autenticacion de usuario**
 - **Método**: GET
 - **Autenticacion**: auth
 - **Tipo**: basic/bearer
 - **URL**: /api/usuarios/token
 - **Descripcion**: 
    Verifica los datos ingresados en la autenticacion de tipo basic, si son iguales a la base de datos 
    Dara un token,donde se deberia de copiar (sin las comillas) y dirigirse a la autenticacion de tipo bearer y
    Pegar el token.
 - **Body**:
  ```json
  {
  "Username": "webadmin",
  "Password": "admin"
  }

**Ejemplo**:
GET /api/usuarios/token