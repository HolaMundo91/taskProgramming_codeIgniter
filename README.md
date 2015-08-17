# programacion_tareas
# Framework: CodeIgniter.
# Lenguajes: Php, javascript, jQuery y HTML5.
# Autor: Pablo Díaz García.
# Video explicativo: 
# Artículo: http://pablojdg.blogspot.com.es/
# Proyecto: http://regaloconsolas.com/

Creación de una función que asigne de forma automática puntos a todos aquellos usuarios que hayan comprado la mensualidad llamada ‘puntos_automaticos’. Esta mensualidad hace que cada cierto tiempo se le asignen puntos a los usuarios sin necesidad de tener que conseguirlos viendo anuncios. Además, se acumula con otras ofertas.

Por ejemplo si un usuario ha comprado la bonificación de ‘puntos_automaticos’ y además tiene la bonificación de conseguir 16 puntos por anuncio, pues cada vez que se ejecute este método, se le asignaran 16 puntos en lugar de 1.

También comprueba que bonificación es mejor. Ya que en regaloconsolas se pueden obtener bonificaciones por 2 lados, por un lado realizando logros y por otro comprando las bonificaciones. Sin embargo, las bonificaciones compradas y las ganadas por logros no se acumulan. Este método, se encarga de ver que bonificación es mejor, si la de logros o la comprada. Una vez comparadas, ejecuta la mejor.
