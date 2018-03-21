<template>
    <gmap-map
        :center="mapCenter"
        :style="mapStyle"
        :zoom="15"
        class="property-listings-map"
              ref="gmap"
      >
      </gmap-map>
</template>

<script>
    import { loaded } from 'vue2-google-maps';

    var Popup;
    export default {
        name: 'properties-map',

        props: {
            properties: {
                type: Array,
                required: true
            }
        },

        data: () =>({
            map: null,
            popups: [],
            mapStyle: 'width: 100%; height: 100%;'
        }),

        mounted() {
            this.$refs.gmap.$mapCreated.then((map) => {
                this.definePopupClass();
                this.generatePopups();
                this.map = map;
            });
        },

        computed: {
            mapCenter() { return { lat: 53.5444, lng: -113.4909 } }
        },

        methods: {
            definePopupClass() {
                Popup = function(position, content, id) {
                    this.position = position;

                    content.classList.add('popup-bubble-content');

                    var pixelOffset = document.createElement('div');
                    pixelOffset.classList.add('popup-bubble-anchor');
                    pixelOffset.appendChild(content);

                    this.anchor = document.createElement('div');
                    this.anchor.classList.add('popup-tip-anchor');
                    this.anchor.id = id;
                    this.anchor.appendChild(pixelOffset);

                    this.stopEventPropagation();
                  };

                  Popup.prototype = Object.create(google.maps.OverlayView.prototype);

                  Popup.prototype.onAdd = function() {
                    this.getPanes().floatPane.appendChild(this.anchor);
                  };

                  Popup.prototype.onRemove = function() {
                    if (this.anchor.parentElement) {
                      this.anchor.parentElement.removeChild(this.anchor);
                    }
                  };

                  Popup.prototype.draw = function() {
                    var divPosition = this.getProjection().fromLatLngToDivPixel(this.position);
                    var display =
                        Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000 ?
                        'block' :
                        'none';

                    if (display === 'block') {
                      this.anchor.style.left = divPosition.x + 'px';
                      this.anchor.style.top = divPosition.y + 'px';
                    }
                    if (this.anchor.style.display !== display) {
                      this.anchor.style.display = display;
                    }
                  };

                  Popup.prototype.stopEventPropagation = function() {
                    var anchor = this.anchor;
                    anchor.style.cursor = 'auto';

                    ['click', 'dblclick', 'contextmenu', 'wheel', 'mousedown', 'touchstart',
                     'pointerdown']
                        .forEach(function(event) {
                          anchor.addEventListener(event, function(e) {
                            e.stopPropagation();
                          });
                        });
                  };
            },

            generatePopups() {
                //this.popups.forEach(p => p.remove());
                //this.popups = [];

                this.properties.forEach(p => {
                    var el = document.createElement('div'),
                        id = 'property-tooltip-' + p.id;
                    el.innerHTML = '&#36;' + parseInt(p.price).toFixed(2);
                    var popup = new Popup( new google.maps.LatLng(p.coordinates.lat, p.coordinates.lng), el, id);
                    popup.setMap(this.map);
                    this.popups.push(popup);
                });
            }
        },

        watch: {
            properties(val) {
                this.generatePopups();
            }
        }
    }
</script>