/* anotaciones valakax*/

Guia para entender el tema salient 

Esta compuesto de una libreria / plugin llamado nectar, en esa carpeta se puede encontrar

** assets/ css, js para algunas de las funciones especificas de sus contenidos / ocultar meta box en nectar-meta.js :: 26,27
** meta en esta carpeta por ejemplo se genera la meta data como ser los box para el post  / post-meta.php quote

Otra carpeta importante con contenidos que utiliza este tema es includes
** post-template / en esta carpeta tenemos las plantillas de los diferentes diseños para categorias, hechas por tipo de categoria. Por eso tienen el nombre, mas las default del sistema. Enlaces de interes y En los medios usan entry que es la default.

** post-template-pre-3-6/ NO SE USA

dentro de la carpeta raiz salient/
*** category, con la base de cada categorias personalizada. Pero el diseño del contenido esta en includes.
*** footer y header con el diseño de esas dos secciones fijas de la pagina
*** index como la categoria por default
*** shortcodes_valakax.php donde hay codigo personalizado para agregar algunas funcionalidades
*** sidebar.php que apunta a un contenido de elementor para poder utilizarlo y personalizarlo desde la administracion
*** template-*... que son las diferentes plantillas personalizadas para tener slider, sidebar, ambas o ninguna, para personalizar pantallas