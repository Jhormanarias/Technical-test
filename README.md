# **Prueba Técnica: API CRUD con Laravel y Docker**

## **Descripción**
Este proyecto es una API desarrollada en Laravel para gestionar operaciones CRUD de **Compañías** y **Contactos**, con autenticación mediante **JWT (JSON Web Tokens)**. Incluye una estructura robusta utilizando contenedores con **Docker** para una configuración y despliegue eficientes.

---

## **Requerimientos del Sistema**
- **Docker** (Versiones recientes de Docker y Docker Compose).
- **Git** (Para clonar el repositorio).
- **PostgreSQL** (Configurado como servicio en Docker).
- **Composer** (Administrado automáticamente dentro del contenedor).

---

## **Instrucciones para la Instalación**

### **1. Clonar el repositorio**
Ejecuta el siguiente comando para clonar el proyecto:
```bash
git clone https://github.com/Jhormanarias/technical-test.git
```

### **2. Configurar el archivo `.env`**
Copia el archivo `.env.example` y renómbralo como `.env` tanto para la API como para la base de datos:
```bash
cp .env.example .env
```

Edita las variables del archivo `.env` y asegúrate de configurar las credenciales de la base de datos correctamente:
```dotenv
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=prueba_tecnica
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña
JWT_SECRET=tu_clave_secreta_generada
```

### **3. Construir los contenedores con Docker**
Ejecuta el siguiente comando para construir los servicios definidos en `docker-compose.yml`:
```bash
docker-compose build
```

### **4. Levantar los contenedores**
Después de construir los contenedores, inicia el proyecto con:
```bash
docker-compose up -d
```

### **5. Instalar dependencias con Composer**
Accede al contenedor del servicio de la API para instalar las dependencias necesarias:
```bash
docker-compose exec api-novadeha bash
composer install
```

### **6. Ejecutar las migraciones**
Ejecuta las migraciones desde dentro del contenedor para configurar las tablas necesarias en la base de datos:
```bash
php artisan migrate
```

---

## **Ejecución del Proyecto**

Con los contenedores en funcionamiento, puedes acceder a la API a través de `http://localhost:8000`. Asegúrate de que los endpoints protegidos incluyan un token JWT válido en las cabeceras de la solicitud.

---

## **Uso de la API**

### **Autenticación**
Los endpoints de autenticación permiten:
1. **Registro** de usuarios:
   ```http
   POST /api/register
   ```
2. **Inicio de sesión**:
   ```http
   POST /api/login
   ```
3. **Cierre de sesión** (requiere token válido):
   ```http
   POST /api/logout
   ```

### **CRUD de Compañías**
1. Obtener todas las compañías:
   ```http
   GET /api/companies
   ```
2. Crear una nueva compañía:
   ```http
   POST /api/companies
   ```
3. Obtener una compañía específica (con contactos):
   ```http
   GET /api/companies/{id}
   ```
4. Actualizar una compañía:
   ```http
   PUT /api/companies/{id}
   ```
5. Eliminar una compañía:
   ```http
   DELETE /api/companies/{id}
   ```

### **CRUD de Contactos**
1. Obtener todos los contactos:
   ```http
   GET /api/contacts
   ```
2. Crear un nuevo contacto:
   ```http
   POST /api/contacts
   ```
3. Obtener un contacto específico:
   ```http
   GET /api/contacts/{id}
   ```
4. Actualizar un contacto:
   ```http
   PUT /api/contacts/{id}
   ```
5. Eliminar un contacto:
   ```http
   DELETE /api/contacts/{id}
   ```

---

## **Estructura del Proyecto**
El proyecto sigue una arquitectura limpia con la lógica separada en controladores, modelos y servicios:

- **Controladores**: Manejan las solicitudes HTTP.
- **Modelos**: Representan las tablas de la base de datos y sus relaciones.
- **Servicios**: Manejan la lógica de negocio (No está implementada).

---

## **Notas Importantes**
- El contenedor de la base de datos persiste los datos en la carpeta `data/pg_data`.
- La relación polimórfica para **Notas** está pendiente de implementación, pero se planificó en detalle para optimizar la escalabilidad y el uso de Eloquent.

---

## **Desarrollador**
Desarrollado por Jhorman Gañan Arias.

---