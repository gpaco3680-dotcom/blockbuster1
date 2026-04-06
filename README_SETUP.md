# 🚀 Blockbuster - Guía de Configuración MySQL

## 📋 Requisitos del Sistema

Antes de ejecutar el proyecto, asegúrate de tener instalados:

### 🔧 Software Requerido
- **PHP 8.2+** - Lenguaje de servidor
- **MySQL 8.0+** - Base de datos
- **Composer** - Gestor de dependencias PHP
- **Git** - Control de versiones

## 🗄️ Configuración de MySQL

### Opción 1: XAMPP (Más Fácil - Recomendado)

#### Paso 1: Instalar XAMPP
1. Descarga XAMPP desde: https://www.apachefriends.org/
2. Ejecuta el instalador como **administrador**
3. Selecciona componentes: Apache, MySQL, PHP
4. Instala en `C:\xampp` (ubicación por defecto)

#### Paso 2: Iniciar Servicios
1. Abre **XAMPP Control Panel** como administrador
2. Haz clic en **Start** para:
   - ✅ Apache (servidor web)
   - ✅ MySQL (base de datos)

#### Paso 3: Configurar Base de Datos
1. **Opción A: Automática (Recomendada)**
   - Ejecuta `setup_mysql.bat` (doble clic)
   - Ingresa las credenciales cuando se solicite

2. **Opción B: Manual**
   - Abre línea de comandos en la carpeta del proyecto
   - Ejecuta: `mysql -u root < config_database.sql`

### Opción 2: MySQL Server Independiente

#### Paso 1: Instalar MySQL Server
1. Descarga MySQL Installer: https://dev.mysql.com/downloads/installer/
2. Ejecuta como administrador
3. Selecciona "Developer Default" o "Server only"
4. Configura password para root (recuérdala)

#### Paso 2: Agregar al PATH
1. Busca la carpeta de instalación (ej: `C:\Program Files\MySQL\MySQL Server 8.0\bin`)
2. Agrega esa ruta al PATH del sistema:
   - Variables de entorno → Path → Editar → Nuevo

#### Paso 3: Configurar Base de Datos
1. Abre PowerShell/CMD como administrador
2. Navega a la carpeta del proyecto
3. Ejecuta `setup_mysql.bat`

### Opción 3: WAMP Server

#### Paso 1: Instalar WAMP
1. Descarga WAMP: https://www.wampserver.com/
2. Instala como administrador
3. Inicia WAMP (icono verde en barra de tareas)

#### Paso 2: Configurar Base de Datos
1. Abre phpMyAdmin desde WAMP
2. O usa `setup_mysql.bat` desde la carpeta del proyecto

## 🚀 Inicio del Servidor

### Opción 1: Servidor Integrado de CodeIgniter
```bash
cd blockbuster
php spark serve
```
Accede a: `http://localhost:8080`

### Opción 2: Usando XAMPP
1. Coloca el proyecto en `C:\xampp\htdocs\blockbuster`
2. Accede a: `http://localhost/blockbuster/public`

## 🔐 Credenciales de Acceso

Después de configurar la base de datos, usa estas credenciales:

### 👑 Administrador
- **Email:** admin@blockbuster.com
- **Password:** Blockbuster2026!
- **Panel:** `/admin/usuarios`

### ⚙️ Operador
- **Email:** operador@blockbuster.com
- **Password:** Operador2026!
- **Panel:** `/operador/clientes`

### 👤 Cliente
- **Email:** cliente@blockbuster.com
- **Password:** Cliente2026!
- **Panel:** `/cliente/catalogo`

## 🛠️ Solución de Problemas

### ❌ "mysql no se reconoce como comando"
- MySQL no está en el PATH
- Agrega `C:\xampp\mysql\bin` o la ruta de tu instalación al PATH

### ❌ "Access denied for user"
- Credenciales incorrectas
- El usuario root no tiene los permisos necesarios
- Ejecuta MySQL Workbench como administrador

### ❌ "Can't connect to MySQL server"
- MySQL no está ejecutándose
- Verifica servicios en el Administrador de Tareas
- Reinicia XAMPP/WAMP

### ❌ "Base de datos no existe"
- Ejecuta primero `setup_mysql.bat`
- O ejecuta manualmente el script SQL

### ❌ "Error 500" en el navegador
- Verifica que PHP esté funcionando
- Revisa logs en `writable/logs/`
- Confirma que las extensiones MySQL de PHP estén habilitadas

## 📁 Archivos de Configuración

- `config_database.sql` - Script SQL completo
- `setup_mysql.bat` - Configuración automática
- `setup.php` - Script PHP alternativo
- `app/Config/Database.php` - Configuración de CodeIgniter

## 🎯 Verificación de Instalación

Para verificar que todo funciona:

1. **MySQL corriendo:** `mysql -u root -p -e "SELECT 1"`
2. **Base de datos existe:** `mysql -u root -p -e "SHOW DATABASES LIKE 'blockbuster'"`
3. **Usuario creado:** `mysql -u root -p -e "SELECT User FROM mysql.user WHERE User='blockbuser'"`
4. **Servidor PHP:** Accede a `http://localhost:8080` y ve la página de login

¡El sistema está listo para usar! 🎉