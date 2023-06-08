<!DOCTYPE html>
<html>
<head>
  <title>Visor de PDF</title>
  <style>
    #the-canvas {
      border: 1px solid black;
      direction: ltr;
    }
    body{
      font-family: Arial, Helvetica, sans-serif;
    }
    .btnOscuro {
  background-color: #124026 !important;
  color: white;
  padding-top: 0.7em;
  padding-bottom: 0.7em;
  -webkit-box-shadow: 10px 10px 13px -5px rgba(18, 64, 38, 0.57);
  -moz-box-shadow: 10px 10px 13px -5px rgba(18, 64, 38, 0.57);
  box-shadow: 5px 5px 8px -5px rgba(18, 64, 38, 0.57);
}
.botones{
  width: 20%;
  

}
.centrado{
  margin:auto;
  text-align: center;
  margin-bottom: 0.2em;
}
canvas {
    padding: 0;
    margin: auto;
    display: block;
    width: 800px;
}
  </style>
</head>
<body>
<!--   HTML -->
  <?define("ROOT",$_SERVER['DOCUMENT_ROOT'] . "/dehesa/");
	define("BASE_URL", "https://www.dehesagestion.es/dehesa/");
	?>
  <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>

<canvas class="centrado" id="the-canvas"></canvas>

<!-- JAVASCRIPT -->
  <script>
    let root='<?= ROOT?>';
    let base_url='<?=BASE_URL?>';
    let numFactura = localStorage["numFactura"];
    
    // Ruta al archivo PDF en tu servidor
    //var pdfUrl = base_url+"app/assets/documentos/"+numFactura+".pdf";

    // If absolute URL from the remote server is provided, configure the CORS
    // header on that server.
    var url = base_url+"app/assets/documentos/"+numFactura+".pdf";

    // Loaded via <script> tag, create shortcut to access PDF.js exports.
    var pdfjsLib = window['pdfjs-dist/build/pdf'];

    // The workerSrc property shall be specified.
    pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

    var pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 2.5,
        canvas = document.getElementById('the-canvas'),
        ctx = canvas.getContext('2d');

    /**
     * Get page info from document, resize canvas accordingly, and render page.
     * @param num Page number.
     */
    function renderPage(num) {
      pageRendering = true;
      // Using promise to fetch the page
      pdfDoc.getPage(num).then(function(page) {
        var viewport = page.getViewport({scale: scale});
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        // Render PDF page into canvas context
        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };
        var renderTask = page.render(renderContext);

        // Wait for rendering to finish
        renderTask.promise.then(function() {
          pageRendering = false;
          if (pageNumPending !== null) {
            // New page rendering is pending
            renderPage(pageNumPending);
            pageNumPending = null;
          }
        });
      });

    }

    /**
     * If another page rendering in progress, waits until the rendering is
     * finised. Otherwise, executes rendering immediately.
     */
    function queueRenderPage(num) {
      if (pageRendering) {
        pageNumPending = num;
      } else {
        renderPage(num);
      }
    }


    /**
     * Asynchronously downloads PDF.
     */
    pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
      pdfDoc = pdfDoc_;

      // Initial/first page rendering
      renderPage(pageNum);
    });
    </script>
</body>
</html>