import {
  Component, OnInit, Input, ChangeDetectionStrategy,
  AfterViewInit, ElementRef, ViewEncapsulation
} from '@angular/core';

import {LayoutService} from '../../layout/layout.service';
import {config} from '../../smartadmin.config';

//noinspection TypeScriptUnresolvedFunction
const $script = require('scriptjs');

declare var d3: any;
declare var topojson: any;


@Component({
  selector: 'd3-map',
  template: `
  <div class="d3-zoomin" (click)="zoomIn()"><i class="fa fa-plus"></i></div>
  <div class="d3-zoomout" (click)="zoomOut()"><i class="fa fa-minus"></i></div>
  <div ngNonBindable class="d3-map"></div>`,
  styleUrls: ['./d3-map.component.css'],
  encapsulation: ViewEncapsulation.None,

  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class D3MapComponent implements AfterViewInit {

  @Input() data: any = [];

  countries: any;

  zoom: any;
  container: any;
  width: any;
  height: any;
  offsetL: any;
  offsetT: any;

  topo: any;
  projection: any;
  path: any;
  svg: any;
  g: any;

  graticule: any;
  tooltip: any;

  color: any;


  private initialized = false;
  private layoutSub: any;

  constructor(private el: ElementRef, private layoutService: LayoutService) {

    this.layoutSub = this.layoutService.subscribe(() => {
      this.initialized && this.throttle();
    })
  }

  ngAfterViewInit() {
    $script(['https://d3js.org/d3.v4.min.js',
      'https://d3js.org/topojson.v1.min.js'], () => {
      this.d3Init();
    })
  }

  d3Init() {
    d3.select(window).on("resize", this.throttle.bind(this));

    this.zoom = d3.zoom()
    //.extent([1,9])
      .scaleExtent([1, 20])
      .on("zoom", this.move.bind(this));

    this.container = d3.select(this.getContainer());
    this.width = this.getContainer().offsetWidth;
    this.height = Math.max(this.width / 2, 300);

    //offsets for tooltips
    this.offsetL = this.container.offsetLeft + 20;
    this.offsetT = this.container.offsetTop + 10;

    //var graticule = d3.geo.graticule();
    this.graticule = d3.geoGraticule();

    this.tooltip = this.container.append("div").attr("class", "tooltip hidden");

    this.setup(this.width, this.height);

    d3.json(config.API_URL + '/graphs/d3/world-topo-min.json', (err, world) => {
      world.objects.countries.geometries = world.objects.countries.geometries.map((it) => {
        it.properties.value = this.data[it.properties.name];
        return it;
      })
      this.countries = topojson.feature(world, world.objects.countries).features;

      const maxVal = Object.keys(this.data).reduce((current, next) => {
        return current >= this.data[next] ? current : this.data[next]
      }, 0)

      this.color = d3.scaleLinear().domain([0, maxVal])
        .range([0, 100])
        // .interpolate(d3.interpolateRgb.gamma(2.2)("purple", "orange"))
        .range([d3.color('rgba(0, 113, 164, 0.6)'), d3.color('rgba(0, 113, 164, 1)')])
        .nice(100)

      this.draw();
      this.initialized = true;
    })
  }

  setup(width, height) {
    //projection = d3.geo.mercator()
    this.projection = d3.geoMercator()
      .translate([(width / 2), (height / 2)])
      .scale(width / 2 / Math.PI);

    //path = d3.geo.path().projection(projection);
    this.path = d3.geoPath().projection(this.projection);

    this.svg = this.container.append("svg")
      .attr("width", width)
      .attr("height", height)
      .call(this.zoom)
      .on("click", this.click.bind(this))

    this.g = this.svg.append("g")


    this.zoom.scaleBy(this.svg.transition().duration(750), 0.9);
    this.zoom.translateBy(this.svg.transition().duration(750), 0, 20);


  }


  handleMouseOver(country) {

    const mouse = d3.mouse(this.svg.node()).map((d) => {
      return parseInt(d);
    });

    this.tooltip.classed("hidden", false)
      .attr("style", "left:" + (mouse[0] + this.offsetL) + "px;top:" + (mouse[1] + this.offsetT) + "px")
      .html(country.properties.name);


  }

  handleMouseOut() {
    this.tooltip.classed("hidden", true);
  }


  isVisible() {
    const container = this.getContainer();
    return (
      container.clientHeight > 0 &&
      container.clientWidth > 0
    );
  }

  isInViewport() {
    const container = this.getContainer();
    const rect = container.getBoundingClientRect();

    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }

  draw() {
    if (!this.isVisible()) return;

    // this.svg.append("path")
    //   .datum(this.graticule)
    //   .attr("class", "graticule")
    //   .attr("d", this.path);


    // this.g.append("path")
    //   .datum({ type: "LineString", coordinates: [[-180, 0], [-90, 0], [0, 0], [90, 0], [180, 0]] })
    //   .attr("class", "equator")
    //   .attr("d", this.path);


    const country = this.g.selectAll(".country").data(this.countries);

    country.enter().insert("path")
      .attr("class", "country")
      .attr("d", this.path)
      .attr("id", (d, i) => {
        return d.id;
      })
      .attr("title", (d, i) => {
        return d.properties.name;
      })
      .style("stroke", d3.color('white'))
      .style("fill", (d, i) => {
        return !d.properties.value ? d3.color('rgba(0, 113, 164, 0.0)') : this.color(d.properties.value);
      })
      .style("stroke-width", '0.5')
      .on("mouseover", this.handleMouseOver.bind(this))
      .on("mouseout", this.handleMouseOut.bind(this));


    //tooltips
    /*
     d3.select("#container svg path")
     .on("mousemove", function(d,i) {
     console.log(d);
     var mouse = d3.mouse(svg.node()).map( function(d) { return parseInt(d); } );

     tooltip.classed("hidden", false)
     .attr("style", "left:"+(mouse[0]+offsetL)+"px;top:"+(mouse[1]+offsetT)+"px")
     .html(d.properties.name);

     })
     .on("mouseout",  function(d,i) {
     tooltip.classed("hidden", true);
     }); */


  }


  redraw() {
    this.width = this.getContainer().offsetWidth;
    this.height = Math.max(this.width / 2, 300);
    d3.select('svg').remove();
    this.setup(this.width, this.height);
    this.draw();
  }

  move() {

    //const t = d3.event.translate;
    const t = [d3.event.transform.x, d3.event.transform.y];
    //const s = d3.event.scale; 
    const s = d3.event.transform.k;
    const zscale = s;
    const h = this.height / 4;

    t[0] = Math.min(
      (this.width / this.height) * (s - 1),
      Math.max(this.width * (1 - s), t[0])
    );

    t[1] = Math.min(
      h * (s - 1) + h * s,
      Math.max(this.height * (1 - s) - h * s, t[1])
    );

    //zoom.translateBy(t);
    this.g.attr("transform", "translate(" + t + ")scale(" + s + ")");

    //adjust the country hover stroke width based on zoom level
    // d3.selectAll(".country").style("stroke-width", 1.5 / s);

  }


  zoomIn() {
    this.zoom.scaleBy(this.svg.transition().duration(750), 1.3);
  }

  zoomOut() {
    this.zoom.scaleBy(this.svg.transition().duration(750), 0.7);
  }

  throttleTimer;

  throttle() {
    window.clearTimeout(this.throttleTimer);
    this.throttleTimer = window.setTimeout(() => {
      this.redraw();
    }, 200);
  }

  //geo translation on mouse click in map
  click() {
    const latlon = this.projection.invert(d3.mouse(this.svg.node()));
    console.log(latlon);
  }


  //function to add points and text to the map (used in plotting capitals)
  addpoint(lon, lat, text) {

    const gpoint = this.g.append("g").attr("class", "gpoint");
    const x = this.projection([lon, lat])[0];
    const y = this.projection([lon, lat])[1];

    gpoint.append("svg:circle")
      .attr("cx", x)
      .attr("cy", y)
      .attr("class", "point")
      .attr("r", 1.5);

    //conditional in case a point has no associated text
    if (text.length > 0) {

      gpoint.append("text")
        .attr("x", x + 2)
        .attr("y", y + 2)
        .attr("class", "text")
        .text(text);
    }

  }


  cachedContainer: any;

  getContainer() {
    if (!this.cachedContainer) {
      this.cachedContainer = this.el.nativeElement.querySelector('.d3-map')
    }
    return this.cachedContainer
  }

}
