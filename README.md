# Dehesa
Aplicación de gestión de explotaciones de ganado bovino.

NOTAS DE DESARROLLO:

  **LA APLICACIÓN SE PUEDE PROBAR EN LA SIGUIENTE URL HABILITADA PARA REALIZAR PRUEBAS: https://www.dehesagestion.es/dehesa/
  
  **ESTA APLICACIÓN ESTARÁ EN CONSTANTE CAMBIO HASTA EL 5 DE JUNIO de 2023.
 
 
  **CONSIDERACIONES GENERALES:
  
  CREDENCIALES DE ACCESO PARA PROBAR APLICACIÓN: 
    -USUARIO: admin
    -PASSWORD: 1234
   
  - La paginación que se usa en todos los listados es de elaboración propia, sé que hay librerías que ya lo hacen y mejor pero 
  como este proyecto es para demostrar habilidades me pareció bien hacerlo yo.
  
  - No se ha usado ninguna plantilla de base para construir la aplicación, todo el apartado estético ha sido de diseño propio,
  incluido el logo.
  
  - El framework que se utiliza es un MVC parecido a CodeIgniter de elaboración propia durante el curso, lo hicimos así porque
  de esta forma aprenderíamos mejor su funcionamiento interno, es muy sencillo en comparación con los que se suelen usar.
    
  **FUNCIONALIDADES ACTUALES: 
  
    - ANIMALES: Crud completo de animales. Al dar de alta un animal indicando que la causa es nacimiento se genera un parto
    automático. El panel lateral se usa para aplicar filtros a estos listados. Al acceder a esta opción del menú aparecen dos
    pestañas superiores: animales y partos. En cada una de ellas se podrá consultar información, pero un parto solo puede
    darse de alta al registrar el nacimiento de un animal.
    
    - INCIDENCIAS: Esta opción del menú es muy siliar a la de animales. Aquí se recoge un listado con las incidencias que se
    produzcan en la explotación. Si al dar de alta a un animal por nacimiento se indica que el parto ha sido asistido, automática-
    mente se registrará una incidencia. El usuario puede también registrar todas las que quiera.
    
    - GRUPOS: Reparto de animales de la explotación en grupos. Cada grupo está asociado a un terreno, al acceder a los detalles de un
    grupo se mostrará una nueva vista en la que este se carga en un lateral, dejando el otro para el resumen de los demás grupos.
    Se pueden cambiar animales de grupo utilizando drag and drop en la cruceta que aparece en el listado (falta poner una imagen
    para mostrar mientras se arrastra).
    
    - TAREAS: Esta opción del menú tiene dos pestañas a su vez, calendario y listado. 
       - En el calendario podemos ver todas las tareas agendadas con fullcalendar, además se pueden añadir nuevas, modificar las  
       actuales y borrarlas.
       - El listado es un añadido extra por si el usuario prefiere usar la interfaz del resto de la aplicación por comodidad.
       -Se puede cambiar una tarea de fecha haciendo drag and drop.
    
  - FACTURAS: Se pueden listar y filtrar facturas existentes. La bbdd ya cuenta con las tablas necesarias y se han creado triggers para actualizar el subtotal, el iva, el irpf y el total en función de las líneas de factura que se añadan. 
  - Ya hay un crud completo de facturas y se pueden visualizar (visor de pdf), descargar y consultar (modal) además de borrar.
  
  - CARGA INICIAL DE DATOS:
  - Ya se puede realizar una carga inicial de datos a la explotación a partir de un XML. Se debe cargar un documento XML y al pulsar el botón 'subir' se realizará la carga de animales y se generarán partos automáticamente. También se les asignará un tipo en función de su edad o características.
  
  **HAY FUNCIONALIDADES INCOMPLETAS EN LAS QUE ESTOY TRABAJANDO EN ESTE MOMENTO:
  
    - TAREAS > CALENDARIO: Falta editar la tabla de tareas y algunos campos para añadir fecha de inicio y fecha de fin a las mismas.
    
    - INCIDENCIAS: avisos cuando se produzca una nueva. Comprobar tiempo entre partos de nodrizas de la explotación al iniciar
    la aplicación para que se generen de forma automática.
    
