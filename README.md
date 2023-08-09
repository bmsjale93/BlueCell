# Formulario Bluecell para WordPress
Formulario Bluecell es un plugin simple para WordPress que permite a los usuarios insertar un formulario de contacto en las entradas individuales. Los datos del formulario se guardan en la base de datos y pueden ser visualizados desde el panel de administración de WordPress.

# Características

Formulario de contacto en las entradas individuales.
Validación del formulario con jQuery.
Envío del formulario mediante AJAX.
Los datos del formulario se guardan en una tabla específica en la base de datos.
Interfaz en el panel de administración para visualizar los datos enviados.
Integración con DataTables para una mejor visualización y gestión de los datos.
Eliminación de la tabla de datos al desinstalar el plugin.

# Instalación
Descarga el plugin y colócalo en la carpeta wp-content/plugins/ de tu instalación de WordPress.
Ve al panel de administración de WordPress y navega a Plugins > Plugins instalados.
Busca "Formulario Bluecell" en la lista y haz clic en Activar.
Una vez activado, el formulario se mostrará automáticamente al final de cada entrada individual.

# Uso
Una vez instalado y activado, el formulario se mostrará en todas las entradas individuales.
Los usuarios pueden completar el formulario y enviarlo.
Los administradores pueden ir al panel de administración y hacer clic en la opción "Formulario Bluecell" en el menú lateral para ver todos los datos enviados.

# Análisis externo
Si deseas analizar el funcionamiento del plugin de forma externa:
1. Base de datos: Puedes acceder a la base de datos de WordPress y buscar la tabla con el prefijo formulario_bluecell. Aquí se guardarán todos los datos del formulario.
2. Consola del navegador: Al enviar el formulario, puedes observar las llamadas AJAX en la consola del navegador para asegurarte de que se están realizando correctamente.
3. Código: Puedes revisar el código del plugin para asegurarte de que sigue las mejores prácticas de desarrollo de WordPress y PHP.

# Desinstalación
Si decides desinstalar el plugin:

Ve al panel de administración de WordPress y navega a Plugins > Plugins instalados.
Busca "Formulario Bluecell" en la lista y haz clic en Desactivar y luego en Eliminar.
Al eliminar el plugin, la tabla formulario_bluecell también se eliminará de la base de datos.
