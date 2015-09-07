<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Latest compiled and minified CSS-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <!--Latest compiled and minified JavaScript-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="logo-img-container">
<img class="center-logo" src="Learning-Illustrator.png"/>
</div>

  <section class="container">
    <div id="carousel">
      <figure id="log"><a href="create.php"><h3> Log a Sleep Cycle</h3></a></figure>
      <figure id="cycle"><a href="log.php"><h3>View Sleep Cycles</h3></a></figure>
      <figure id="app"><a href="about.html"><h3>Read About This App</h3></a></figure>
  </div>
  </section>
  <section id="options">
    <p>
      <input type="hidden" id="panel-count" value="3"/>
    </p>
  </section>

  <p id="navigation">
    <button id="previous" data-increment="-1"><</button>
    <button id="next" data-increment="1">></i></button>
  </p>
<body>


  <script src="../js/utils.js"></script>
  <script>
    var transformProp = Modernizr.prefixed('transform');
    function Carousel3D ( el ) {
      this.element = el;
      this.rotation = 0;
      this.panelCount = 0;
      this.totalPanelCount = this.element.children.length;
      this.theta = 0;
      this.isHorizontal = true;
    }
    Carousel3D.prototype.modify = function() {
      var panel, angle, i;
      this.panelSize = this.element[ this.isHorizontal ? 'offsetWidth' : 'offsetHeight' ];
      this.rotateFn = this.isHorizontal ? 'rotateY' : 'rotateX';
      this.theta = 360 / this.panelCount;
      // do some trig to figure out how big the carousel
      // is in 3D space
      this.radius = Math.round( ( this.panelSize / 2) / Math.tan( Math.PI / this.panelCount ) );
      for ( i = 0; i < this.panelCount; i++ ) {
        panel = this.element.children[i];
        angle = this.theta * i;
        panel.style.opacity = 1;
        // rotate panel, then push it out in 3D space
        panel.style[ transformProp ] = this.rotateFn + '(' + angle + 'deg) translateZ(' + this.radius + 'px)';
      }
      // hide other panels
      for (  ; i < this.totalPanelCount; i++ ) {
        panel = this.element.children[i];
        panel.style.opacity = 0;
        panel.style[ transformProp ] = 'none';
      }
      // adjust rotation so panels are always flat
      this.rotation = Math.round( this.rotation / this.theta ) * this.theta;
      this.transform();
    };
    Carousel3D.prototype.transform = function() {
      // push the carousel back in 3D space,
      // and rotate it
      this.element.style[ transformProp ] = 'translateZ(-' + this.radius + 'px) ' + this.rotateFn + '(' + this.rotation + 'deg)';
    };
    var init = function() {
      var carousel = new Carousel3D( document.getElementById('carousel') ),
          panelCountInput = document.getElementById('panel-count'),
          axisButton = document.getElementById('toggle-axis'),
          navButtons = document.querySelectorAll('#navigation button'),
          onNavButtonClick = function( event ){
            var increment = parseInt( event.target.getAttribute('data-increment') );
            carousel.rotation += carousel.theta * increment * -1;
            carousel.transform();
          };
      // populate on startup
      carousel.panelCount = parseInt( panelCountInput.value, 10);
      carousel.modify();
      panelCountInput.addEventListener( 'change', function( event ) {
        carousel.panelCount = event.target.value;
        carousel.modify();
      }, false);
      for (var i=0; i < 2; i++) {
        navButtons[i].addEventListener( 'click', onNavButtonClick, false);
      }
      setTimeout( function(){
        document.body.addClassName('ready');
      }, 0);
    };
    window.addEventListener( 'DOMContentLoaded', init, false);
  </script>
</body>
