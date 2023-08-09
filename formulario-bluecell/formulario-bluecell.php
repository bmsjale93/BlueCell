<?php
/*
Nombre del Plugin: Formulario Bluecell
Descripción: Formulario para prueba en BlueCell
Versión: 1.0
Autor: Alejandro Delgado Martínez
*/

// Insertar el formulario en single.php
function insertar_formulario($contenido) {
    // Si es una entrada individual (post)
    if(is_single()) {
        // Crear el formulario HTML
        $formulario = '<form id="formularioBluecell">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <textarea name="mensaje" placeholder="Mensaje" required></textarea>
            <input type="text" name="asunto" placeholder="Asunto" required>
            <input type="checkbox" name="politicas" required>Acepto las políticas de privacidad
            <input type="submit" value="Enviar">
        </form>';
        // Añadir el formulario al contenido
        $contenido .= $formulario;
    }
    return $contenido;
}
add_filter('the_content', 'insertar_formulario');

// Crear la tabla en la base de datos al activar el plugin
function instalar_bluecell() {
    global $wpdb;
    $nombre_tabla = $wpdb->prefix . 'formulario_bluecell';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $nombre_tabla (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nombre varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        telefono varchar(255) NOT NULL,
        mensaje text NOT NULL,
        asunto varchar(255) NOT NULL,
        fecha datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'instalar_bluecell');

// Cargar jQuery y validar/enviar el formulario con AJAX
function cargar_scripts() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'cargar_scripts');

function js_formulario() {
    echo '
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $("#formularioBluecell").submit(function(e) {
                e.preventDefault();
                // Validación aquí...
                $.ajax({
                    url: "'.admin_url('admin-ajax.php').'",
                    type: "POST",
                    data: {
                        action: "guardar_formulario",
                        data: $(this).serialize()
                    },
                    success: function(response) {
                        // Acciones tras enviar el formulario...
                    }
                });
            });
        });
    </script>';
}
add_action('wp_footer', 'js_formulario');

// Guardar datos del formulario en la base de datos
function guardar_formulario() {
    global $wpdb;
    $nombre_tabla = $wpdb->prefix . 'formulario_bluecell';

    $wpdb->insert($nombre_tabla, array(
        'nombre' => $_POST['nombre'],
        'email' => $_POST['email'],
        'telefono' => $_POST['telefono'],
        'mensaje' => $_POST['mensaje'],
        'asunto' => $_POST['asunto'],
        'fecha' => current_time('mysql')
    ));

    echo "Formulario enviado con éxito!";
    wp_die();
}
add_action('wp_ajax_guardar_formulario', 'guardar_formulario');
add_action('wp_ajax_nopriv_guardar_formulario', 'guardar_formulario');

// Pantalla en el CMS para ver los datos del formulario
function menu_admin_bluecell() {
    add_menu_page(
        'Formulario Bluecell',
        'Formulario Bluecell',
        'manage_options',
        'formulario-bluecell',
        'pagina_admin',
        'dashicons-feedback',
        6
    );
}
add_action('admin_menu', 'menu_admin_bluecell');

function pagina_admin() {
    echo '<div class="wrap">';
    echo '<h1>Entradas del Formulario Bluecell</h1>';

    echo '<table id="tablaBluecell" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Mensaje</th>
                <th>Asunto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>';

    global $wpdb;
    $nombre_tabla = $wpdb->prefix . 'formulario_bluecell';
    $resultados = $wpdb->get_results("SELECT * FROM $nombre_tabla", ARRAY_A);

    foreach ($resultados as $fila) {
        echo '<tr>';
        echo '<td>' . esc_html($fila['id']) . '</td>';
        echo '<td>' . esc_html($fila['nombre']) . '</td>';
        echo '<td>' . esc_html($fila['email']) . '</td>';
        echo '<td>' . esc_html($fila['telefono']) . '</td>';
        echo '<td>' . esc_html($fila['mensaje']) . '</td>';
        echo '<td>' . esc_html($fila['asunto']) . '</td>';
        echo '<td>' . esc_html($fila['fecha']) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';

    echo '<script type="text/javascript">
        jQuery(document).ready(function($) {
            $("#tablaBluecell").DataTable();
        });
    </script>';

    echo '</div>';
}

function scripts_admin($hook) {
    if ($hook != 'toplevel_page_formulario-bluecell') {
        return;
    }
    wp_enqueue_style('datatables', 'https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css');
    wp_enqueue_script('datatables', 'https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js', array('jquery'));
}
add_action('admin_enqueue_scripts', 'scripts_admin');

// Eliminar tabla al desinstalar el plugin
function desinstalar_bluecell() {
    global $wpdb;
    $nombre_tabla = $wpdb->prefix . 'formulario_bluecell';
    $wpdb->query("DROP TABLE IF EXISTS $nombre_tabla");
}
register_uninstall_hook(__FILE__, 'desinstalar_bluecell');
