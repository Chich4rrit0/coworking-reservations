# Instrucciones para el Sistema de Reservas de Coworking

## Requisitos previos
- PHP 8.2 o superior
- MySQL 8.1
- Composer
- Servidor web (Apache, Nginx, etc.)

## Instalación

1. **Configurar la base de datos**:
   - Crear una base de datos MySQL llamada `coworking`
   - Configurar el archivo `.env` con las credenciales de la base de datos

2. **Instalar dependencias**:
   ```
   composer install
   ```

3. **Ejecutar migraciones y seeders**:
   ```
   php artisan migrate --seed
   ```

4. **Crear el enlace simbólico para el almacenamiento**:
   ```
   php artisan storage:link
   ```

5. **Iniciar el servidor** (opcional, si no estás usando un servidor web):
   ```
   php artisan serve
   ```

## Usuarios predeterminados

El sistema viene con dos usuarios predeterminados:

1. **Administrador**:
   - Email: admin@example.com
   - Contraseña: password

2. **Cliente**:
   - Email: cliente@example.com
   - Contraseña: password

## Funcionalidades principales

### Para clientes:
1. **Registro e inicio de sesión**:
   - Los clientes pueden registrarse en la aplicación
   - Al registrarse, automáticamente se les asigna el rol de "cliente"

2. **Reserva de salas**:
   - Ver las salas disponibles
   - Seleccionar una sala, fecha y hora para la reserva
   - Las reservas son siempre de 1 hora de duración
   - El sistema verifica automáticamente que no haya otra reserva en el mismo horario
   - Las reservas se crean con estado "Pendiente"

3. **Gestión de reservas**:
   - Ver el listado de sus propias reservas
   - Ver el estado de cada reserva (Pendiente, Aceptada, Rechazada)

### Para administradores:
1. **Gestión de salas**:
   - Crear nuevas salas con nombre y descripción
   - Editar salas existentes
   - Eliminar salas

2. **Gestión de reservas**:
   - Ver todas las reservas de todos los clientes
   - Filtrar reservas por sala
   - Cambiar el estado de las reservas a "Aceptada" o "Rechazada"

3. **Exportación a Excel**:
   - Exportar todas las reservas a un archivo Excel
   - El archivo incluye información de Cliente, Sala, Hora de reserva
   - También incluye estadísticas de tiempo total de reserva por sala según días

## Notas importantes

- Las reservas son siempre de 1 hora de duración
- Solo los administradores pueden cambiar el estado de las reservas
- Los clientes solo pueden ver sus propias reservas
- Los administradores pueden ver todas las reservas
- El sistema verifica automáticamente la disponibilidad de las salas antes de confirmar una reserva