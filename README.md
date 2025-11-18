# TicketsFESC  
_Plataforma institucional para la gestión integral de incidentes en la FESC_

TicketsFESC es un sistema de gestión de incidentes desarrollado en **Laravel** que permite registrar, asignar, rastrear y resolver anomalías en aulas, equipos y accesos físicos dentro de la Fundación de Estudios Superiores Comfanorte (FESC). El sistema opera con un flujo de trabajo basado en roles, reflejando la estructura jerárquica institucional y garantizando trazabilidad completa del ciclo de vida de cada incidente.

---

## 📌 Propósito del Sistema

TicketsFESC centraliza y estandariza la atención de incidentes relacionados con infraestructura académica:

- **Informes de anomalías**  
  Registro de fallas en equipos, problemas eléctricos, aire acondicionado, mobiliario y cualquier anomalía en aulas o laboratorios.

- **Gestión del control de acceso**  
  Solicitudes de apertura/cierre de aulas, programación de uso y administración de permisos temporales.

- **Seguimiento del ciclo de vida del incidente**  
  Control completo desde el reporte inicial → asignación → gestión → resolución → cierre, con auditoría del historial de cambios.

El sistema aplica un riguroso modelo **RBAC** (Role-Based Access Control) con aprobación obligatoria de superadministrador para nuevas cuentas y seguimiento histórico de todas las acciones relevantes.

---

## 🛠️ Pila Tecnológica

| Componente               | Tecnología                    | Versión   | Propósito |
|-------------------------|-------------------------------|-----------|-----------|
| Framework               | Laravel                       | ^10.10    | Backend MVC |
| Lenguaje                | PHP                           | ^8.1      | Lado del servidor |
| Autenticación (UI)      | Laravel Breeze                | ^1.29     | Login, registro, perfiles |
| API Auth                | Laravel Sanctum               | ^3.3      | Tokens API |
| Autorización            | Spatie Permission             | ^6.21     | Gestión de roles y permisos |
| Generación de PDF       | DomPDF                        | ^3.1      | Exportación de reportes |
| Build Frontend          | Vite                          | —         | Compilación y HMR |
| Framework CSS           | TailwindCSS + Flowbite        | ^3.2      | Estilos y componentes |
| JS Reactivo             | Alpine.js                     | —         | Interactividad ligera |
| Cliente HTTP            | Guzzle                        | ^7.2      | Solicitudes HTTP |
| Base de Datos           | MySQL / PostgreSQL            | —         | Almacenamiento relacional |

---

## 🧱 Arquitectura de la Aplicación

### 🔷 Arquitectura por Capas  
<img width="1178" height="912" alt="image" src="https://github.com/user-attachments/assets/f757fd0c-f341-4af2-9d88-d16533cf0751" />

**Descripción:**  
La arquitectura organiza el sistema en cinco capas:

1. **Presentación** – Renderizado SSR mediante Blade.  
2. **Routing & Middleware** – Pila de seguridad: `auth`, `verified`, `role`, `can`.  
3. **Controladores** – Orquestación de lógica sin reglas de negocio directas.  
4. **Business Logic** – Gestión de incidentes, autenticación, autorizaciones, reportes.  
5. **Capa de Datos** – Modelos Eloquent, relaciones, migraciones y repositorios.

---

## 🔁 Flujo Principal de Peticiones

<img width="1131" height="684" alt="image" src="https://github.com/user-attachments/assets/01ba89d0-63d9-45c5-b1e9-85c0fb91e6a0" />

**Descripción:**  
El proceso típico para visualizar incidentes involucra:

- Validación en middleware (`auth`, `verified`, `role`, `can`)  
- Filtro dinámico por rol  
- Consultas optimizadas con **Eager Loading**  
- Aplicación de filtros adicionales (estado, categoría, fechas)  
- Renderizado paginado vía Blade

---

## 🧩 Modelo de Dominio Central

### Jerarquía de Roles

<img width="1678" height="476" alt="image" src="https://github.com/user-attachments/assets/5d7845c8-696c-44a6-98f7-f4c362ea6c52" />

**Descripción:**  
El sistema implementa cinco roles clave con permisos escalonados:

- **superadmin** – Acceso irrestricto y gestión completa de usuarios.  
- **admin_infraestructura** – Administración de incidentes y asignación a operativos.  
- **operativo_servicio** – Gestiona incidentes asignados y actualiza estados.  
- **director_programa** – Visualiza incidentes por ubicación y genera informes.  
- **docente_solicitante** – Crea incidentes y visualiza únicamente los propios.

---

## 🗂️ Modelo de Datos de Incidentes

<img width="1253" height="841" alt="image" src="https://github.com/user-attachments/assets/a30693b6-4a58-4184-a91a-bc80854133b9" />

**Descripción:**  
La entidad central es `Incidente`, que contiene:

- `id`, `titulo`, `descripcion`, `estado`, `prioridad`, `fecha_reporte`  
- Relaciones con:
  - `Categoria`
  - `Ubicacion`
  - Usuarios (`reportado_por`, `asignado_a`)
  - `Comentario`
  - `HistorialEstado`

---

## 🔄 Máquina de Estados del Incidente

<img width="765" height="741" alt="image" src="https://github.com/user-attachments/assets/4265ad9b-126f-41d2-b837-5f68156e85e9" />

**Estados principales:**

- `reportado`
- `asignado`
- `en_progreso`
- `resuelto`
- `cerrado`
- `reabierto`

**Descripción:**  
Los incidentes fluyen desde `reportado` (vía formulario) hacia `asignado` por un administrador, luego `en_progreso` y posteriormente `resuelto` o `cerrado`. Cualquier incidente puede pasar a `reabierto` con registro obligatorio en el historial de auditoría.

---

## ⚙️ Subsistema de Gestión de Incidentes

| Ruta                        | HTTP     | Método                | Propósito | Middleware |
|-----------------------------|----------|------------------------|-----------|------------|
| `incidentes.index`         | GET      | index()               | Listado por rol | auth, verified |
| `incidentes.create`        | GET      | create()              | Formulario | auth |
| `incidentes.store`         | POST     | store()               | Crear incidente | auth |
| `incidentes.show`          | GET      | show($id)             | Ver detalle | auth |
| `incidentes.edit`          | GET      | edit($id)             | Editar | auth |
| `incidentes.update`        | PUT/PATCH| update($id)           | Actualizar | auth |
| `incidentes.destroy`       | DELETE   | destroy($id)          | Eliminar | auth |
| `incidentes.asignar`       | POST     | asignar($id)          | Asignar operativo | can:assign |
| `incidentes.cambiar-estado`| POST     | cambiarEstado($id)    | Cambiar estado | can:changeStatus |
| `incidentes.comentar`      | POST     | comentar($id)         | Agregar comentario | can:addComment |

---

## 🎨 Arquitectura Frontend

<img width="1680" height="714" alt="image" src="https://github.com/user-attachments/assets/5d334acb-af2a-4072-9670-b12551486da7" />

**Descripción:**  
La interfaz está construida con Blade, Tailwind y Alpine.js:

- `layouts/app.blade.php` define el marco general (sidebar, header, footer).  
- Soporte para **modo claro/oscuro** con persistencia en localStorage.  
- Componentes reutilizables: tarjetas, tablas, formularios, modales, alertas.  
- Integración con rutas protegidas y sistemas de permisos.

---

## 🌐 Organización del Enrutamiento

<img width="825" height="346" alt="image" src="https://github.com/user-attachments/assets/ca04b009-a4ef-4ae7-90ec-44742371ae99" />

**Descripción:**

1. **Rutas Públicas:** bienvenida, políticas, información institucional.  
2. **Rutas Autenticadas:** panel, incidentes, perfil, contraseñas.  
3. **Rutas de Administración:** gestión de usuarios y roles.  
4. **Rutas de Autenticación:** login, registro, verificación OTP/email, recuperación.

---

## 🚀 Secuencia de Inicialización

<img width="871" height="811" alt="image" src="https://github.com/user-attachments/assets/058d0cae-7b31-4f49-9148-9f7fe45bfc51" />

**Descripción:**  
El despliegue y preparación del entorno de desarrollo incluye:

1. `composer install`  
2. Configuración de `.env`  
3. `php artisan key:generate`  
4. Migraciones: usuarios, roles, incidentes, categorías, ubicaciones, historial, comentarios  
5. Seeders: creación de roles institucionales  
6. Instalación de dependencias frontend: `npm install`  
7. Compilación: `npm run dev`  
8. Inicio de servidor: `php artisan serve`

# Fotos

### Imagen Welcome
![Welcome](https://github.com/user-attachments/assets/7b909929-9f7d-4e8d-bafe-264bcbb2850d)

### Imagen PreRegistro
![PreRegistro](https://github.com/user-attachments/assets/1d081757-79c8-475b-a8e5-929316c27674)

### Imagen Login
![Login](https://github.com/user-attachments/assets/5a3f8b8b-51ff-4929-a13d-28ea66780f00)

### Imagen Recuperar Contraseña
![Recuperar Contraseña](https://github.com/user-attachments/assets/ea16f808-14f1-45ec-a0d8-626b814647b1)

### Imagen Dashboard
![Dashboard](https://github.com/user-attachments/assets/dc76e213-3669-4ce0-accd-5c324e7c796a)

### Imagen Navbar
![Navbar](https://github.com/user-attachments/assets/07ac9cb6-4913-405f-a353-706eda6248bd)

### Imagen Politicas
![Politicas](https://github.com/user-attachments/assets/18bdf40b-369d-4239-9107-afd08b608415)

### Imagen Privacidad 
![privacidad](https://github.com/user-attachments/assets/7ebd1898-efeb-41b0-a18d-c6214ef0461b)

### Imagen Equipo
![Equipo](https://github.com/user-attachments/assets/9b1cdb4e-c6a3-4e7b-8163-aeda9fcac174)

### Imagen Configuración
![Configuracion](https://github.com/user-attachments/assets/72895356-8978-475c-93e7-865fc172a9e1)

### Imagen ControlUsuario
![ControlDeUsuario](https://github.com/user-attachments/assets/4801232d-371e-43eb-a485-0225901c0c4d)

### Imagen Aprobación
![AprobacionDialogBox](https://github.com/user-attachments/assets/f25630a5-a1af-46dc-bedd-71fe293c3d35)

### Imagen rechazoDialogBox
![rechazoDialogBox](https://github.com/user-attachments/assets/c4a12881-a8ed-4bd1-b833-cdace15b1bf6)

### Imagen editarDialogBox
![editarDialogBox](https://github.com/user-attachments/assets/74a10189-7279-4d43-a81c-22e6a53ae129)

### Imagen eliminarDialogBox
![eliminarDialogBox](https://github.com/user-attachments/assets/c048215b-d929-47db-99ec-da3627340d6e)

### Imagen crear
![crear](https://github.com/user-attachments/assets/409535e9-6b5f-4dbe-bfb1-466501a60ea9)

### Imagen show
![show](https://github.com/user-attachments/assets/a433cde8-37c8-4819-8adc-1dfce9af8d18)

### Imagen historial
![historial](https://github.com/user-attachments/assets/658f1e05-3d3f-40dd-bbc1-0d02d1f177bf)

### Imagen editar
![editar](https://github.com/user-attachments/assets/b92f80a2-ec98-491b-beaf-a1ef2930a467)

### Imagen tabla
![index](https://github.com/user-attachments/assets/bf9faa3d-ec1b-4284-8889-8094b9603856)

### Imagen exportar
![exportar](https://github.com/user-attachments/assets/1b7995e6-84f0-4b7b-8e54-e6faf84d2dda)

### Imagen reporte
![reporte](https://github.com/user-attachments/assets/7c75f39a-4e49-44ed-97ec-6fee8976eabb)

### Imagen OperativoDashboard
![operativoDashboard](https://github.com/user-attachments/assets/c02be0be-2fba-4122-915b-9308fb30e97b)

### Imagen operativoNotificacion
![OperativoNoti](https://github.com/user-attachments/assets/8a1463bd-bda5-4bd5-9494-70ae69e54822)

### Imagen Dark
![Dark](https://github.com/user-attachments/assets/42ec7418-a970-4faa-9bb6-a13b449f13bf)

### Imagen Dark 2
![Dark2](https://github.com/user-attachments/assets/a3acca81-c87b-43ed-b966-f377d7b99807)
