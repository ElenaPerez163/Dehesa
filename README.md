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
    
  - FACTURAS: Se pueden listar y filtrar facturas existentes. La bbdd ya cuenta con las tablas necesarias y se han creado triggers para actualizar el subtotal, el iva, el irpf y el total en función de las líneas de factura que se añadan. Trabajando actualmente en el crud completo y en la generación del pdf.
  **HAY FUNCIONALIDADES INCOMPLETAS EN LAS QUE ESTOY TRABAJANDO EN ESTE MOMENTO:
  
    - TAREAS > CALENDARIO: Ahora mismo solo es un CRUD básico, falta manejar los eventos de drag and drop y editar
    la tabla de tareas y algunos campos para añadir fecha de inicio y fecha de fin a las mismas.
 
    - FACTURAS: Ahora mismo estoy trabajando en generar la factura y las líneas de factura desde la interfaz. Para generar las
    facturas utilizaré la librería HTML2PDF.
    
    - CARGA INICIAL DE DATOS EN BBDD: Ya la realizo desde fuera de la interfaz con un script php y un archivo XML con los datos
    de la explotación. Falta integrar esto en el framework MVC y generar un botón que lance una ventana modal para cargar el 
    archivo.
    
    - INCIDENCIAS: avisos cuando se produzca una nueva. Comprobar tiempo entre partos de nodrizas de la explotación al iniciar
    la aplicación para que se generen de forma automática.
    
