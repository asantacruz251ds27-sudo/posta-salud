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

