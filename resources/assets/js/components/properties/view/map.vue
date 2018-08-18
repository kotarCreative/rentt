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
    import {
        loaded
    } from 'vue2-google-maps';

    var Popup;
    export default {
        name: 'properties-map',

        props: {
            searchComplete: {
                type: Boolean
            }
        },

        data: () => ({
            map: null,
            popups: [],
            mapStyle: 'width: 100%; height: 100%;',
            swBound: null,
            neBound: null,
            mapCenter: {
                lat: 53.5444,
                lng: -113.4909
            }
        }),

        mounted() {
            this.$refs.gmap.$mapPromise.then((map) => {
                this.map = map;
                this.definePopupClass();
            });
        },

        computed: {
            properties() { return this.$store.getters['properties/all'] }
        },

        methods: {
            centerMap() {
                if (this.swBound && this.neBound) {
                    var bounds = new google.maps.LatLngBounds(this.swBound, this.neBound);
                    this.$refs.gmap.panToBounds(bounds, 100);
                    this.$refs.gmap.fitBounds(bounds);
                }
            },

            compareCoordinates(coord1, coord2) {
                if (coord1.lat() > coord2.lat() && coord1.lng() > coord2.lng()) {
                    // North East
                    return 'ne';
                } else if (coord1.lat() > coord2.lat() && coord1.lng() < coord2.lng()) {
                    // North West
                    return 'nw';
                } else if (coord1.lat() < coord2.lat() && coord1.lng() > coord2.lng()) {
                    // South East
                    return 'se';
                } else if (coord1.lat() < coord2.lat() && coord1.lng() < coord2.lng()) {
                    // South West
                    return 'sw';
                } else {
                    return 'equal';
                }
            },

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

                    [
                        'click',
                        'dblclick',
                        'contextmenu',
                        'wheel',
                        'mousedown',
                        'touchstart',
                        'pointerdown'
                    ]
                    .forEach(function(event) {
                        anchor.addEventListener(event, function(e) {
                            e.stopPropagation();
                        });
                    });
                };
            },

            generatePopups() {
                /* Reset popups */
                this.popups.forEach(p => {
                    p.setMap(null);
                });
                this.popups = [];
                this.neBound = null;
                this.swBound = null;

                this.properties.forEach(p => {
                    var el = document.createElement('div'),
                        id = 'property-tooltip-' + p.id,
                        coord = new google.maps.LatLng(p.coordinates.lat, p.coordinates.lng);
                    el.innerHTML = '&#36;' + parseInt(p.price).toFixed(2);
                    var popup = new Popup(coord, el, id);
                    popup.setMap(this.map);
                    this.popups.push(popup);

                    //Extend bounds if popup is outside current bounds
                    if (!this.swBound) {
                        this.swBound = coord;
                    } else {
                        var comparison = this.compareCoordinates(coord, this.swBound);
                        if (comparison === 'sw') {
                            this.swBound = coord
                        } else if (comparison === 'nw') {
                            this.swBound = new google.maps.LatLng(this.swBound.lat(), coord.lng());
                        }
                    }

                    if (!this.neBound) {
                        this.neBound = coord;
                    } else {
                        var comparison = this.compareCoordinates(coord, this.neBound);
                        if (comparison === 'ne') {
                            this.neBound = coord;
                        } else if (comparison === 'nw') {
                            this.neBound = new google.maps.LatLng(coord.lat(), this.neBound.lng());
                        }
                    }
                });
            }
        },

        watch: {
            properties(val) {
                this.generatePopups();
                this.centerMap();
            },

            searchComplete(val) {
                this.generatePopups();
                this.centerMap();
            }
        }
    }

</script>
