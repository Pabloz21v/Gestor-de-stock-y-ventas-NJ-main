# Sistema de Gestión de Menús de Restaurante

Este proyecto es un sistema de gestión de menús para restaurantes, desarrollado con Laravel, Vue.js, e Inertia.js. El sistema permite la administración de categorías, subcategorías, y platos, así como la creación de puntos de restauración de datos, backups automáticos, y una interfaz de usuario responsive.

## Características

- **Gestión de Categorías, Subcategorías y Platos**: Permite crear, editar, eliminar y visualizar categorías, subcategorías, y platos.
- **Filtros Avanzados**: Filtrado dinámico de platos por categoría, subcategoría, y búsqueda por nombre, con soporte para búsquedas insensibles a acentos.
- **Historial de Cambios**: Registro de todas las modificaciones realizadas en categorías, subcategorías y platos.
- **Puntos de Restauración**: Creación de backups automáticos y manuales de las tablas de categorías, subcategorías y platos.
- **Interfaz Responsive**: Diseño responsive que se adapta tanto a dispositivos móviles como a pantallas de escritorio.
- **Modales de Confirmación**: Uso de modales para confirmar la eliminación de elementos.
- **Spinners de Carga**: Indicadores de carga que se muestran durante operaciones de actualización y eliminación.

## Accesos


Tablero del Admin (dueño):
puede crear Editores (empleados) 
email: admin@admin.com
pass: admin

email: tester2@admin.com
pass: admin

email: tester1@admin.com
pass: admin

Tablero empleados:
email: editor@editor.com
pass: editor

## Requisitos

- PHP >= 8.0
- Composer
- Node.js & NPM
- MySQL

## Instalación

1. **Clonar el repositorio:**

    git clone https://github.com/tu-usuario/menu-restaurant-proyect.git
    cd nombre-repo

2. **Instalar dependencias de PHP:**

    composer install

3. **Instalar dependencias de Node.js:**

    npm install

4. **Configurar el archivo .env:**

Copia el archivo .env.example a .env y actualiza las variables necesarias (base de datos).

    cp .env.example .env
    php artisan key:generate

5. **Migrar la base de datos:**

    php artisan migrate --seed

6. **Compilar los assets:**

    npm run dev

7. **Iniciar el servidor:**

    php artisan serve

## Uso

**Gestión de Categorías, Subcategorías y Platos**
Puedes agregar, editar, y eliminar categorías, subcategorías y platos desde el panel de administración.
El filtro de platos permite buscar por nombre, y filtrar por categoría o subcategoría.
Si se borra una categoria, borra en cascada sus subcategorias y platos
Si borra una subcategoria, borra en cascada sus platos

Puntos de Restauración
Se crean automáticamente cada semana y puedes crear manualmente desde la vista de Backup. (configurar cron en tu servidor)
Se puede crear puntos de restauracion manualmente
Los puntos de restauración permiten revertir los datos de las tablas de categorías, subcategorías y platos a un estado anterior.

Historial de Cambios
El sistema mantiene un registro de todas las modificaciones realizadas en categorías, subcategorías y platos, incluyendo quién realizó el cambio y los datos antiguos y nuevos.

Creacion de editores
El administrador principal puede crear acceso para sus empleados (editor).

Existen dos rangos para el panel de administracion
Editor: solo accede a creacion, edicion y eliminacion de categorias, subcategorias y platos.
Admin: lo mismo que editor, mas vista del historial, manejo de puntos de restauracion y creacion de editores.