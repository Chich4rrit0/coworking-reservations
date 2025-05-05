# Sistema de Reservas de Coworking

Este proyecto es una aplicación web desarrollada en Laravel para gestionar la reserva de espacios en un cowork. La aplicación permite a los clientes registrarse, iniciar sesión y hacer reservaciones en las salas de coworking, mientras que los administradores pueden gestionar las salas y supervisar las reservaciones realizadas por los clientes.

## Requisitos

- PHP 8.2 o superior
- MySQL 8.1
- Composer
- Node.js y NPM (opcional, para compilar assets)

## Instalación

1. Clonar el repositorio:
```
git clone https://github.com/tu-usuario/coworking-reservations.git
cd coworking-reservations
```

2. Instalar dependencias:
```
composer install
```

3. Configurar el archivo .env:
```
cp .env.example .env
php artisan key:generate
```

4. Configurar la base de datos en el archivo .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coworking
DB_USERNAME=root
DB_PASSWORD=
```

5. Ejecutar migraciones y seeders:
```
php artisan migrate --seed
```

6. Iniciar el servidor:
```
php artisan serve
```

## Usuarios por defecto

- **Administrador**:
  - Email: admin@example.com
  - Password: password

- **Cliente**:
  - Email: cliente@example.com
  - Password: password

## Funcionalidades

### Roles de Usuario

- **Administrador**: Puede gestionar salas, cambiar el estado de las reservaciones y ver las reservaciones por sala.
- **Cliente**: Puede registrarse, iniciar sesión, hacer reservas en las salas disponibles y listar sus reservaciones.

### Funcionalidad de Cliente

- Registro e inicio de sesión
- Reservaciones de salas:
  - Selección de sala de coworking
  - Fecha y hora de la reserva
  - Las reservas son siempre de una hora de duración
  - Verificación de disponibilidad antes de confirmar
  - Estado inicial de reserva: "Pendiente"

### Funcionalidad de Administrador

- Gestión de salas:
  - Crear, editar y eliminar salas de coworking
  - Cada sala tiene un nombre y una descripción opcional
- Gestión de reservas:
  - Cambiar el estado de una reserva de "Pendiente" a "Aceptada" o "Rechazada"
  - Listar todas las reservas y filtrarlas por sala de coworking
- Exportar a Excel:
  - Exportar documento Excel con todas las reservas generadas
  - Incluye Cliente, Sala, Hora de reserva
  - Muestra el Total de tiempo de reserva por Sala según días

## Tecnologías utilizadas

- Laravel 12
- PHP 8.2
- MySQL 8.1
- Bootstrap 5
- Backpack for Laravel (Admin Panel)
- PhpSpreadsheet (para exportación a Excel)

## Licencia

Este proyecto está licenciado bajo la Licencia MIT.