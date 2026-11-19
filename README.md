# Ideas

Aplicación web para **llevar un registro de las ideas de proyectos, organizadas por categoría**, y darles seguimiento hasta que se aprueban o se rechazan.

Hecha con **PHP, Laravel y Filament**.

## El problema

Las ideas para proyectos suelen quedar repartidas en notas sueltas, mensajes o documentos, y es difícil saber cuáles existen, de qué tema son y en qué punto está cada una.

Ideas centraliza ese registro: cada idea se guarda con su categoría, su autor y su estado, para poder consultarla, revisarla y decidir qué hacer con ella.

## Funcionalidades

- **Registro de ideas** con título, descripción, autor, categoría, estado y observaciones.
- **Categorías** para clasificar las ideas (el proyecto incluye cuatro de ejemplo: Tecnología, Educación, Salud y Medio ambiente).
- **Flujo de revisión** con cuatro estados: registrada, en revisión, aprobada y rechazada. Las ideas se pueden aprobar o rechazar desde la tabla, y al rechazar se escribe el motivo.
- **Eliminación lógica**: las ideas eliminadas van a una papelera, desde donde se pueden restaurar o borrar definitivamente.
- **Panel de estadísticas** con el total de ideas, el total de categorías y gráficas por estado y por categoría.
- **Roles de usuario** (administrador, coordinador y asistente) con permisos distintos.

## Roles y permisos

Los permisos se definen con políticas de Laravel (`IdeaPolicy` y `CategoriaPolicy`).

| Acción | Administrador | Coordinador | Asistente |
| --- | :---: | :---: | :---: |
| Ver ideas y categorías | ✔ | ✔ | ✔ |
| Crear ideas y categorías | ✔ | | |
| Editar ideas y categorías | ✔ | | ✔ |
| Eliminar o restaurar ideas | ✔ | | ✔ |
| Eliminar categorías | ✔ | | |
| Aprobar o rechazar ideas | ✔ | ✔ | |

El rol de cada usuario se guarda en la columna `rol` de la tabla `users` (por defecto, `asistente`).

## Tecnologías

| Área | Herramientas |
| --- | --- |
| Lenguaje | PHP 8.3 o superior |
| Framework | Laravel 13 |
| Panel de administración | Filament 5 |
| Base de datos | SQLite (por defecto; configurable en `.env`) |
| Frontend | Vite |
| Pruebas | Pest (configurado) |

## Modelo de datos

```
categorias                      ideas
----------                      -----
id (PK)                         idIdea (PK)
nombre                          titulo
descripcion                     descripcion
created_at, updated_at          estado            (por defecto: registrada)
                                observacion       (opcional)
                                autor
                                categoria_id (FK → categorias.id)
                                created_at, updated_at
                                deleted_at        (eliminación lógica)
```

Una **categoría** tiene muchas **ideas**, y cada idea pertenece a una sola categoría. La tabla `users` incluye la columna `rol`.

## Instalación

Requisitos: PHP 8.3 o superior, Composer, Node.js y npm.

```bash
git clone https://github.com/uniqueP4ris/Ideas.git
cd Ideas

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

npm install
npm run build

php artisan serve
```

El comando `composer setup` ejecuta la instalación de dependencias, la copia del `.env`, la clave de la aplicación, las migraciones y la compilación de los archivos del frontend.

El panel está en `http://localhost:8000/admin`.

### Usuarios y roles

`php artisan migrate --seed` crea las categorías y las ideas de ejemplo, además de algunos usuarios de demostración. Para trabajar con los tres roles:

```bash
# Crea los usuarios coordinador y asistente con su rol
php artisan db:seed --class=UserSeeder

# Crea un usuario para entrar al panel
php artisan make:filament-user
```

Después, asigna el rol de administrador a tu usuario:

```bash
php artisan tinker
>>> App\Models\User::where('email', 'tu@correo.com')->update(['rol' => 'admin']);
```

> Las contraseñas de los usuarios de demostración son solo para desarrollo. Cámbialas antes de publicar la aplicación en un servidor.

## Estructura del proyecto

```
app/
├── Filament/
│   ├── Resources/      # Ideas y Categorías (formularios, tablas y vistas)
│   └── Widgets/        # Estadísticas y gráficas del panel
├── Helpers/EstadoIdea.php   # Estados de una idea y sus etiquetas
├── Models/             # Idea, Categoria y User
└── Policies/           # Permisos por rol
database/
├── migrations/         # Estructura de las tablas
└── seeders/            # Categorías, ideas y usuarios de ejemplo
```

## Estado del proyecto

Proyecto en desarrollo. Pendientes y posibles mejoras:

- Agregar pruebas automatizadas propias (hoy solo existen las pruebas de ejemplo de Laravel).
- Incluir la creación de un usuario administrador en los seeders.
- Agregar capturas de pantalla del panel a este README.

## Autor

[Tu nombre] — [github.com/uniqueP4ris](https://github.com/uniqueP4ris)
