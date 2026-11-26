# Pruebas unitarias del módulo Pacientes (Guía 03)

Fecha: 23/11/2026 · Responsable: Angel Santa Cruz

| Caso | Resultado | Observación |
|------|-----------|-------------|
| CP01 | OK | Listado inicial muestra 10 pacientes por página, total 40 y paginación «Siguiente »». |
| CP02 | OK | Búsqueda por DNI completo devuelve un único paciente coincidente. |
| CP03 | OK | Búsqueda por fragmento de apellido en minúsculas filtra correctamente sin distinguir mayúsculas. |
| CP04 | OK | Al avanzar de página con filtro activo, la URL conserva el parámetro `?buscar=`. |
| CP05 | OK | Envío de formulario vacío muestra errores de validación en español en campos obligatorios. |
| CP06 | OK | DNI de 7 dígitos muestra «El DNI debe tener exactamente 8 dígitos.» y conserva los demás datos. |
| CP07 | OK | DNI duplicado es rechazado con «Ya existe un paciente con este DNI.» (RN01). |
| CP08 | OK | Fecha de nacimiento futura muestra «La fecha de nacimiento no puede ser futura.». |
| CP09 | OK | Celular iniciado en 8 muestra «El celular debe empezar con 9.». |
| CP10 | OK | Registro válido redirige a la ficha con aviso verde; el total sube a 41 pacientes. |
| CP11 | OK | Edición de celular mantiene el DNI propio sin falso error de duplicado y muestra aviso verde. |
| CP12 | OK | Edición usando el DNI de otro paciente muestra error de unicidad (RF06, RN01). |
| CP13 | OK | Intento de eliminar paciente con citas muestra aviso rojo y mantiene el registro (RF07). |
| CP14 | OK | Eliminación del paciente sin citas del CP10 muestra aviso verde y el total vuelve a 40 (RF07). |
| CP15 | OK | Acceso a `/pacientes/99999` devuelve respuesta HTTP 404. |

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