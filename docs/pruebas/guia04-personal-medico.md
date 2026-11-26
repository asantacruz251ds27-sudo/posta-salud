# Bitácora de pruebas · Guía 04 (Personal médico)

## 1. Rutas y estructura (Bloque A)
- `php artisan route:list --path=personal-medico`: 7 rutas registradas (recurso sin `destroy` + `PATCH personal-medico/{personalMedico}/estado`), parámetro `{personalMedico}`.
- Constante `PersonalMedico::ESPECIALIDADES` centralizada en el modelo y reutilizada en factory, validación y vistas.

## 2. Listado y filtros combinados (Bloque B · RF08)
- Listado inicial muestra 5 profesionales activos con conteo de citas (`withCount('citas')`) y etiqueta de estado `<x-estado>`.
- Filtro por estado (`Activos` = 5, `Inactivos` = 1, `Todos` = 6) funcionando correctamente.
- Combinación de búsqueda (apellido, DNI o colegiatura) + especialidad + estado mantiene parámetros en paginación (`withQueryString()`).

## 3. Registro y vinculación opcional de cuenta (Bloque C · RF08, RN01)
- Selector de cuenta de usuario muestra únicamente usuarios con rol `personal_medico` sin ficha previa (`Luis Pérez - medico2@posta.test`).
- Validaciones en español verificadas: campos obligatorios, DNI de 8 dígitos únicos, colegiatura de 4 a 6 dígitos única y especialidad dentro de la lista permitida.
- Registro exitoso incrementa el total a 6 profesionales activos.

## 4. Ficha de detalle y edición (Bloque D · RF08)
- Vista `show` muestra datos del profesional, correo de cuenta vinculada (o «Sin cuenta vinculada») y próximas citas pendientes/confirmadas.
- Vista `edit` con `UpdatePersonalMedicoRequest` ignora el propio ID en las reglas `unique` de DNI, colegiatura y `user_id`, rechazando valores pertenecientes a otros registros.

## 5. Baja lógica: Activar / Desactivar (Bloque E · RF08, RN06)
- `PATCH personal-medico/{personalMedico}/estado` alterna el campo booleano `activo` sin eliminar registros ni romper historial de citas.
- Al desactivar, el profesional deja de listarse en el filtro por defecto (`Activos`) y aparece en `Inactivos`; al reactivar vuelve al listado principal.