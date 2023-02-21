<template>
    <div class="container" style="height:560px;background: url('./img/dash.jpg');background-size:cover;">
    <!-- <div style="height:300px;background: url('./img/dash.jpg');background-size:cover;"></div> -->


<div id="container">
    <span id="text1"></span>
    <span id="text2"></span>
</div>

<svg id="filters">
    <defs>
        <filter id="threshold">
            <feColorMatrix in="SourceGraphic" type="matrix" values="1 0 0 0 0
                  0 1 0 0 0
                  0 0 1 0 0
                  0 0 0 255 -140" />
        </filter>
    </defs>
</svg>


    </div>
</template>

<script>
    export default {
        created(){
            windom.animate();

        }
    }


</script>


 <!-- <div class="container">
        <div class="row justify-content-center">
               <not-found></not-found>
        </div>
    </div> -->
