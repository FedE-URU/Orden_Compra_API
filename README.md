[![GitHub](https://img.shields.io/github/last-commit/FedE-URU/Orden_Compra_API?style=flat-square)](https://github.com/FedE-URU/Orden_Compra_API)
[![GitHub Stars](https://img.shields.io/github/stars/FedE-URU/Orden_Compra_API?style=flat-square)](https://github.com/FedE-URU/Orden_Compra_API/stargazers)
[![GitHub Forks](https://img.shields.io/github/forks/FedE-URU/Orden_Compra_API?style=flat-square)](https://github.com/FedE-URU/Orden_Compra_API/network/members)
[![GitHub Issues](https://img.shields.io/github/issues/FedE-URU/Orden_Compra_API?style=flat-square)](https://github.com/FedE-URU/Orden_Compra_API/issues)

# Orden_Compra_API

Sistema de gestión de órdenes de compra online, siguiendo principios de POO, uso de interfaces, patrones de diseño y arquitectura multicapa.

---

## Descripción

Se busca desarrollar un sistema para una empresa intermediaria que:

- Publica un catálogo de productos.
- Recibe órdenes de compra de clientes (particulares o empresas).
- Procesa el pago y, si es una empresa, una orden de pago.
- Cumple y despacha los pedidos mediante una empresa de mensajería externa.

---

## Funcionalidades esperadas

- Consulta y publicación del catálogo.
- Registro y autenticación de clientes.
- Realización de órdenes de compra.
- Generación de comprobantes de pago.
- Gestión de envíos.
- Historial de compras.

---

## Lenguajes implementados

- [ ] HTML + CSS + JS (Web)
- [ ] PHP + MySQL + JavaScript (Web)
- [ ] Bash
- [ ] C#
- [ ] Python
- [ ] React
- [ ] Ruby
- [ ] Angular
- [ ] JavaScript (versión para terminal)

---

## Tecnologías utilizadas

- ASP.NET Core Web API (C#)
- Patrón Repository
- Inyección de dependencias
- Principios SOLID
- Arquitectura en capas
- (Opcional) Entity Framework Core

---
## Estructura del proyecto

#### PHP + MySQL + JavaScript

```plaintext
ordenes-compra-php-js/     (Carpeta raíz del proyecto)
├── backend-php/
│   ├── config/
│   │   └── database.php             # Configuración de la conexión a la BD
│   ├── controllers/
│   │   ├── ProductosController.php  # Lógica para productos
│   │   └── OrdenesController.php    # Lógica para órdenes
│   ├── models/
│   │   ├── Producto.php             # Clase Producto
│   │   ├── Orden.php                # Clase Orden
│   │   └── ItemOrden.php            # Clase Item de Orden
│   ├── api/
│   │   ├── productos.php            # Endpoint para obtener productos
│   │   └── ordenes.php              # Endpoint para procesar órdenes
│   └── .htaccess                    # Reescritura de URLs (opcional)
├── frontend-js/
│   ├── css/
│   │   └── style.css                # Estilos CSS para la interfaz
│   ├── js/
│   │   ├── api.js                   # Funciones para interactuar con la API
│   │   ├── cart.js                  # Lógica del carrito de compras
│   │   └── app.js                   # Lógica principal del frontend (eventos, vistas)
│   └── index.html                   # Página principal del catálogo y checkout
└── database/
    └── schema.sql                   # Script SQL para crear la base de datos y tablas
```
# Pasos para ejecutar (PHP + MySQL + JS)

1.  ### **Configurar la Base de Datos MySQL**
    * Asegúrate de tener un servidor MySQL funcionando (puedes usar **XAMPP**, **WAMP**, **MAMP**, o una instalación directa de MySQL).
    * Accede a tu cliente MySQL preferido (por ejemplo, MySQL Workbench, phpMyAdmin o la línea de comandos `mysql`).
    * Ejecuta el script SQL ubicado en `database/schema.sql` para crear la base de datos y las tablas necesarias, además de insertar algunos datos de ejemplo.

2.  ### **Configurar PHP y el Servidor Web**
    * Verifica que **PHP** esté correctamente configurado y funcionando con tu servidor web (Apache o Nginx son comunes).
    * Coloca la carpeta raíz de este proyecto (`ordenes-compra-php-js/`) en el directorio de documentos de tu servidor web (por ejemplo, `htdocs` para Apache XAMPP/WAMP).

3.  ### **Ajustar la Conexión a la Base de Datos**
    * Abre el archivo `backend-php/config/database.php`.
    * Modifica el `$username` y `$password` de la base de datos para que coincidan con las credenciales de tu servidor MySQL.

4.  ### **Verificar la URL de la API en el Frontend**
    * Edita el archivo `frontend-js/js/api.js`.
    * Asegúrate de que la constante `API_BASE_URL` apunte correctamente a la ruta de tus scripts PHP en el servidor web. Por ejemplo, si colocaste el proyecto en `htdocs/ordenes-compra-php-js/`, la URL debería ser `http://localhost/ordenes-compra-php-js/backend-php/api`.

5.  ### **Acceder al Frontend de la Aplicación**
    * Una vez que los pasos anteriores estén configurados, abre tu navegador web.
    * Navega a la siguiente URL para acceder a la interfaz de usuario: `http://localhost/ordenes-compra-php-js/frontend-js/index.html`.


---
## Contacto

[![GitHub](https://img.shields.io/badge/GitHub-FedE--URU-blue?style=flat-square&logo=github)](https://github.com/FedE-URU)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-federicoesteves-blue?style=flat-square&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/federicoesteves)

---
