# Dehesa
Aplicación de gestión de explotaciones de ganado bovino.

NOTAS DE DESARROLLO:
  **LA APLICACIÓN SE PUEDE PROBAR EN LA SIGUIENTE URL HABILITADA PARA REALIZAR PRUEBAS: https://www.dehesagestion.es/dehesa/
  
  **ESTA APLICACIÓN ESTARÁ EN CONSTANTE CAMBIO HASTA EL 5 DE JUNIO de 2023.
 
  CONSIDERACIONES GENERALES:
  CREDENCIALES DE ACCESO PARA PROBAR APLICACIÓN: 
    -USUARIO: admin
    -PASSWORD: 1234
   
  - La paginación que se usa en todos los listados es de elaboración propia, sé que hay librerías que ya lo hacen y mejor pero 
  como este proyecto es para demostrar habilidades me pareció bien hacerlo yo.
  
  - No se ha usado ninguna plantilla de base para construir la aplicación, todo el apartado estético ha sido de diseño propio,
  incluido el logo.
  
  - El framework que se utiliza es un MVC parecido a CodeIgniter de elaboración propia durante el curso, lo hicimos así porque
  de esta forma aprenderíamos mejor su funcionamiento interno, es muy sencillo en comparación con los que se suelen usar.
    
  FUNCIONALIDADES ACTUALES: 
    - ANIMALES: Crud completo de animales. Al dar de alta un animal indicando que la causa es nacimiento se genera un parto
    automático. El panel lateral se usa para aplicar filtros a estos listados. La paginación que se utiliza es propia, sé
    que hay herramientas que la hacen mejor pero como este proyecto es una prueba me sirvió de práctica.
    
  
  HAY FUNCIONALIDADES INCOMPLETAS EN LAS QUE ESTOY TRABAJANDO EN ESTE MOMENTO:
    - TAREAS > CALENDARIO: Ahora mismo solo es un CRUD básico, falta manejar los eventos de drag and drop y editar
    la tabla de tareas y algunos campos para añadir fecha de inicio y fecha de fin a las mismas.
    - Al pinchar en una tarea, esta se vuelca en el panel lateral, pero si se pulsa en limpiar los botones no cambian a los
    anteriores, esto es lo siguiente en lo que trabajaré, solo es añadir un evento a ese botón.
 
    - FACTURAS: Esta opción está por construir, ahora mismo estoy trabajando en añadir las tablas requeridas a la base de datos
    e incluir triggers para gestionar bajas y altas de animales y líneas de factura al generarlas o borrarlas. Para generar las
    facturas utilizaré la librería HTML2PDF.
    
    - CARGA INICIAL DE DATOS EN BBDD: Ya la realizo desde fuera de la interfaz con un script php y un archivo XML con los datos
    de la explotación. Falta integrar esto en el framework MVC y generar un botón que lance una ventana modal para cargar el 
    archivo.
    
