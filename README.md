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
---
## Contacto

[![GitHub](https://img.shields.io/badge/GitHub-FedE--URU-blue?style=flat-square&logo=github)](https://github.com/FedE-URU)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-federicoesteves-blue?style=flat-square&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/federicoesteves)

---
