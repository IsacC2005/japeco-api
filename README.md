## Japeco API: Puente de Datos Legacy

**Japeco API** es una interfaz de programación de aplicaciones (API) diseñada con el propósito de actuar como **puente de datos** entre sistemas modernos y una base de datos *legacy* desnormalizada.

Este proyecto consume la base de datos de **Japeco**, un sistema de gestión académica antiguo caracterizado por una estructura de datos desnormalizada y código *spaghetti*.

La API no implementa lógica de negocio compleja; su función principal es **exponer y exportar** los datos de esta fuente antigua de manera **limpia, segura y estructurada**, facilitando su consumo por parte de otras aplicaciones modernas (móviles, web, *front-end*, etc.) que requieren acceso a la información académica histórica.

### ⚙️ Arquitectura y Flujo de Datos

El proyecto Japeco API se sitúa como intermediario, desacoplando la capa de datos *legacy* de las aplicaciones de consumo, garantizando que el sistema antiguo permanezca intocado y estable.

El flujo de datos se esquematiza de la siguiente manera:



1.  **Consumo:** La Aplicación Moderna solicita datos a Japeco API.
2.  **Traducción:** Japeco API traduce la solicitud a la sintaxis requerida por la base de datos *legacy* (consultas SQL complejas, etc.).
3.  **Extracción:** Los datos sin procesar se extraen de la base de datos *legacy*.
4.  **Estructura y Respuesta:** Japeco API formatea los datos extraídos en un formato JSON limpio y los envía de vuelta a la Aplicación Moderna.

---

### 🔑 Endpoints Principales

La API expone los datos de la base de datos *legacy* a través de los siguientes *endpoints*. Todos los *endpoints* utilizan el método **`GET`** y están prefijados con la ruta base de tu API (ej: `https://localhost:8000/api/`).

#### 👩‍🏫 Rutas de Profesores (`/teacher`)

| Método | Endpoint                  | Descripción                                                          |
| :----- | :------------------------ | :------------------------------------------------------------------- |
| `GET`  | `/api/teacher/index`      | Lista todos los profesores registrados.                              |
| `GET`  | `/api/teacher/show/{id}`  | Retorna los detalles de un profesor específico por su ID.            |
| `GET`  | `/api/teacher/exist/{id}` | Verifica si un profesor con el ID especificado existe en el sistema. |


#### 📚 Rutas de Secciones y Años Escolares (`/section`)

| Método | Endpoint                                       | Descripción                                                                         |
| :----- | :--------------------------------------------- | :---------------------------------------------------------------------------------- |
| `GET`  | `/api/section/index`                           | Lista todas las secciones (grupos o aulas) disponibles.                             |
| `GET`  | `/api/section/show/{id}`                       | Retorna los detalles de una sección específica por su ID.                           |
| `GET`  | `/api/section/details`                         | Lista todas las secciones con sus detalles completos.                               |
| `GET`  | `/api/section/school-year/details`             | Retorna los detalles de todas las secciones relacionadas con el año escolar actual. |
| `GET`  | `/api/section/assings-teacher/{id}`            | Retorna las secciones asignadas a un profesor específico (por ID de profesor).      |
| `GET`  | `/api/section/teacher-if-assing`               | Verifica si el profesor autenticado está asignado a alguna sección.                 |
| `GET`  | `/api/sections/school-year`                    | Retorna todas las secciones asociadas al año escolar actual.                        |
| `GET`  | `/api/section/find/school-year-and-teacher-id` | Retorna secciones filtradas por el año escolar y el ID del profesor.                |

#### 🧑‍🎓 Rutas de Estudiantes (`/student`)

| Método | Endpoint                       | Descripción                                                                                |
| :----- | :----------------------------- | :----------------------------------------------------------------------------------------- |
| `GET`  | `/api/student/index`           | Lista todos los estudiantes inscritos.                                                     |
| `GET`  | `/api/student/to-section/{id}` | Retorna todos los estudiantes que pertenecen a una sección específica (por ID de sección). |

#### 🩺 Ruta de Diagnóstico

| Método | Endpoint              | Descripción                                                                                                          |
| :----- | :-------------------- | :------------------------------------------------------------------------------------------------------------------- |
| `GET`  | `/api/test-conection` | Endpoint de diagnóstico simple para verificar que la API está operativa y la conexión a la base de datos es exitosa. |

---


### 🛡️ Consideraciones de Seguridad

* **Solo Lectura:** Por diseño, Japeco API solo implementa métodos `GET` y no permite operaciones de escritura (`POST`, `PUT`, `DELETE`), asegurando la integridad de los datos en la base de datos *legacy*.