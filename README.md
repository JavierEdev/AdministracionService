
---

## 🟨 `README.md` - AdministracionService (PHP)

```md
# Administracion Service

Este servicio permite la gestión administrativa de un sistema de transporte, incluyendo la ***administración de lugares, rutas, buses, horarios y reservas***. Forma parte de un sistema distribuido basado en SOA y se encarga de proporcionar las operaciones CRUD necesarias para la gestión de estos recursos.

## 🚀 Tecnologías
- PHP 8+
- MySQL
- Apache / XAMPP / WAMP
- Arquitectura en capas
- Patrones: Factory Method y Data Access Object (DAO)

## 📂 Estructura
AdministracionService/
├── admin.php
├── config/
│   └── db.php
├── controllers/
│   ├── BusesController.php
│   ├── HorariosController.php
│   ├── LugaresController.php
│   ├── ReservasController.php
│   └── RutasController.php
├── factories/
│   └── ControllerFactory.php
├── helpers/
│   └── Response.php
├── models/
│   ├── Bus.php
│   ├── Horario.php
│   ├── Lugar.php
│   ├── Reserva.php
│   ├── Ruta.php
│   └── admin.php
├── daos/
│   ├── interfaces/
│   │   ├── IBusDAO.php
│   │   ├── IHorarioDAO.php
│   │   ├── ILugarDAO.php
│   │   ├── IReservaDAO.php
│   │   └── IRutaDAO.php
│   ├── BusDAO.php
│   ├── HorarioDAO.php
│   ├── LugarDAO.php
│   ├── ReservaDAO.php
│   └── RutaDAO.php


## 🔌 Endpoints

| Método | Ruta                                  | Descripción                                   |
|--------|---------------------------------------|-----------------------------------------------|
| POST   | `/admin.php/lugares`                  | Obtiene todos los lugares                     |
| POST   | `/admin.php/lugares/idLugar`          | Obtiene un lugar por ID                       |
| POST   | `/admin.php/lugares/insertLugar`      | Crea un nuevo lugar                           |
| PUT	 | `/admin.php/lugares/updateLugar`      | Actualiza un lugar existente                  |
| DELETE | `/admin.php/lugares/deleteLugar`      | Elimina un lugar                              |
| POST	 | `/admin.php/rutas`                    | Obtiene todas las rutas                       |    
| POST   | `/admin.php/rutas/idRuta`	         | Obtiene una ruta por ID                       |
| POST	 | `/admin.php/rutas/insertRuta`         |  Crea una nueva ruta                          |
| PUT	 | `/admin.php/rutas/updateRuta`         |  Actualiza una ruta existente                 |
| DELETE | `/admin.php/rutas/deleteRuta`         |  Elimina una ruta                             |
| POST	 | `/admin.php/buses`                    |  Obtiene todos los buses                      |
| POST	 | `/admin.php/buses/idBus`              |  Obtiene un bus por ID                        |
| POST	 | `/admin.php/buses/insertBus`          |  Crea un nuevo bus                            |
| PUT	 | `/admin.php/buses/updateBus`          |  Actualiza un bus existente                   |
| DELETE | `/admin.php/buses/deleteBus`          |  Elimina un bus                               |
| POST	 | `/admin.php/reservas`                 |  Obtiene todas las reservas                   |
| POST	 | `/admin.php/reservas/idReserva`       |  Obtiene una reserva por ID                   | 
| POST	 | `/admin.php/horarios/idRuta`          |  Obtiene horarios por ID de ruta              |
| POST	 | `/admin.php/horarios/idHorario`       |  Obtiene un horario por ID                    |
| POST	 | `/admin.php/horarios/insertHorario`   |  Crea un nuevo horario                        |    
| PUT	 | `/admin.php/horarios/updateHorario`   |  Actualiza un horario existente               |
| DELETE | `/admin.php/horarios/deleteHorario`   |  Elimina un horario                           | 

## ⚙️ Configuración

1. Configura tu base de datos en `config/db.php`.
2. Asegúrate que `mod_rewrite` esté habilitado si usas Apache.
3. Usa Postman o Swagger desde PagosService para probar integración.

## ▶️ Ejecución
Coloca el proyecto en tu servidor Apache local (`htdocs`) y accede a:  
👉 AdministracionService/admin.php

