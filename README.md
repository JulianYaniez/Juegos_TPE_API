# TPE - Parte 3: API REST de Juegos

## Descripción General

Esta API REST ofrece servicios relacionados con la gestión de una base de datos de juegos. Los endpoints permiten listar, agregar, modificar y filtrar juegos.

***Endpoints Disponibles***

### **1. Listar Todos los Juegos**
- **Método**: `GET`
- **URL**: `/api/juegos`
- **Descripción**: Devuelve una lista de todos los juegos disponibles.
- **Query Params**:
  - `ordenarPor` (opcional): Campo por el cual ordenar. `titulo`, `genero`, `id_distribuidora`, `precio`, `fecha_salida`.
  - `orden` (opcional): Orden (`ASC` o `DESC`). Por defecto: `ASC`.
  - `pagina` (opcional): Página de resultados. Debe ser un número entero arriba de 0.
  - `limite` (opcional): Cantidad de elementos a mostrar por página.
  - `criterio`(opcional filtro): Campo por el cual filtrar, incompatible con queryParams anteriores. `distribuidora`.
  - `valor` (opcional filtro): Valor para el criterio de filtro, compatible solo con el queryParam `criterio`. `mayor`, `menor`, `igual`.

**Ejemplo**:
GET /api/juegos?ordenarPor=titulo&orden=ASC&pagina=1&limite=10

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

### **6. Filtrar Juegos**
- **Método**: GET
- **URL**: /api/juegos?criterio={criterio}&valor={valor}
- **Descripción**: Filtra los juegos según un criterio específico.
- **Query Params**:
  - `criterio`: Campo por el cual filtrar (ejemplo: genero).
  - `valor`: Valor para el criterio de filtro.
**Ejemplo**:
GET /api/juegos?criterio=genero&valor=Accion
