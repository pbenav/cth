# Mejoras en el Panel de Fichaje (V1.2.0)

En esta actualización, hemos realizado una revisión profunda del **Panel de Fichaje (Numpad)** para recuperar la esencia y el rendimiento de sus versiones más estables.

## 🔄 Restauración del Diseño Clásico
Hemos vuelto a la estructura visual del commit `c23964fa8`, reconocida por su claridad y facilidad de uso. Esto incluye:
- **Botones con alto contraste**: Mejora la visibilidad en entornos con mucha luz.
- **Transiciones suaves**: Efectos visuales de 0.7 segundos para una respuesta táctil más agradable.
- **Reloj Centrado**: Una mejor alineación visual de la hora actual con respecto al teclado.

## 📱 Optimización para Dispositivos Móviles
A petición de nuestros usuarios, hemos "compactado" verticalmente el teclado:
- **Menos altura**: Se han reducido los márgenes y rellenos internos para que el teclado ocupe menos espacio en pantalla, permitiendo ver más información sin hacer scroll.
- **Branding simplificado**: El logo y el título ahora son más discretos para dar prioridad a la interacción.

## 🌍 Internacionalización Completa
El Panel de Fichaje ahora es totalmente bilingüe:
- Los botones de **Insertar código**, **Restablecer** y **Borrar** ahora cambian automáticamente entre Español e Inglés según la preferencia del usuario.
- Se han mejorado las etiquetas de accesibilidad (`aria-labels`) para lectores de pantalla.

## 🛠️ Estabilización Técnica
Se ha consolidado el código CSS eliminando dependencias de compilación agresivas que causaban errores de visualización aleatorios. Esto garantiza que el teclado se vea **perfecto** en todos los navegadores y dispositivos en cada carga.

---
*© 2026 sientiaCTH - Evolucionando para ti*
