import {Directive, OnInit, ElementRef} from '@angular/core';

import 'script-loader!smartadmin-plugins/bower_components/relayfoods-jquery.sparkline/dist/jquery.sparkline.min.js'

declare var $:any;

@Directive({
  selector: '[saSparklineContainer]'
})
export class SparklineContainer implements OnInit {

  container:any;

  constructor(private el:ElementRef) {
    this.container = this.el.nativeElement;
  }

  ngOnInit() {
    this.drawSparklines();
  }

  barChart($el:any) {
    let barColor = $el.data('sparkline-bar-color') || $el.css('color') || '#0000f0';
    let sparklineHeight = $el.data('sparkline-height') || '26px';
    let sparklineBarWidth = $el.data('sparkline-barwidth') || 5;
    let sparklineBarSpacing = $el.data('sparkline-barspacing') || 2;
    let sparklineNegBarColor = $el.data('sparkline-negbar-color') || '#A90329';
    let sparklineStackedColor = $el.data('sparkline-barstacked-color') || ["#A90329", "#0099c6", "#98AA56", "#da532c", "#4490B1", "#6E9461", "#990099", "#B4CAD3"];

    $el.sparkline('html', {
      barColor: barColor,
      type: 'bar',
      height: sparklineHeight,
      barWidth: sparklineBarWidth,
      barSpacing: sparklineBarSpacing,
      stackedBarColor: sparklineStackedColor,
      negBarColor: sparklineNegBarColor,
      zeroAxis: 'false',
      tooltipContainer: this.container
    });
  }

  lineChart($el:any) {

    let sparklineHeight = $el.data('sparkline-height') || '20px';
    let sparklineWidth = $el.data('sparkline-width') || '90px';
    let thisLineColor = $el.data('sparkline-line-color') || $el.css('color') || '#0000f0';
    let thisLineWidth = $el.data('sparkline-line-width') || 1;
    let thisFill = $el.data('fill-color') || '#c0d0f0';
    let thisSpotColor = $el.data('sparkline-spot-color') || '#f08000';
    let thisMinSpotColor = $el.data('sparkline-minspot-color') || '#ed1c24';
    let thisMaxSpotColor = $el.data('sparkline-maxspot-color') || '#f08000';
    let thishighlightSpotColor = $el.data('sparkline-highlightspot-color') || '#50f050';
    let thisHighlightLineColor = $el.data('sparkline-highlightline-color') || 'f02020';
    let thisSpotRadius = $el.data('sparkline-spotradius') || 1.5;
    let thisChartMinYRange = $el.data('sparkline-min-y');
    let thisChartMaxYRange = $el.data('sparkline-max-y');
    let thisChartMinXRange = $el.data('sparkline-min-x');
    let thisChartMaxXRange = $el.data('sparkline-max-x');
    let thisMinNormValue = $el.data('min-val');
    let thisMaxNormValue = $el.data('max-val');
    let thisNormColor = $el.data('norm-color') || '#c0c0c0';
    let thisDrawNormalOnTop = $el.data('draw-normal') || false;

    $el.sparkline('html', {
      type: 'line',
      width: sparklineWidth,
      height: sparklineHeight,
      lineWidth: thisLineWidth,
      lineColor: thisLineColor,
      fillColor: thisFill,
      spotColor: thisSpotColor,
      minSpotColor: thisMinSpotColor,
      maxSpotColor: thisMaxSpotColor,
      highlightSpotColor: thishighlightSpotColor,
      highlightLineColor: thisHighlightLineColor,
      spotRadius: thisSpotRadius,
      chartRangeMin: thisChartMinYRange,
      chartRangeMax: thisChartMaxYRange,
      chartRangeMinX: thisChartMinXRange,
      chartRangeMaxX: thisChartMaxXRange,
      normalRangeMin: thisMinNormValue,
      normalRangeMax: thisMaxNormValue,
      normalRangeColor: thisNormColor,
      drawNormalOnTop: thisDrawNormalOnTop,
      tooltipContainer: this.container

    });
  }

  pieChart($el) {
    let pieColors = $el.data('sparkline-piecolor') || ["#B4CAD3", "#4490B1", "#98AA56", "#da532c", "#6E9461", "#0099c6", "#990099", "#717D8A"];
    let pieWidthHeight = $el.data('sparkline-piesize') || 90;
    let pieBorderColor = $el.data('border-color') || '#45494C';
    let pieOffset = $el.data('sparkline-offset') || 0;

    $el.sparkline('html', {
      type: 'pie',
      width: pieWidthHeight,
      height: pieWidthHeight,
      tooltipFormat: '<span style="color: {{color}}">&#9679;</span> ({{percent.1}}%)',
      sliceColors: pieColors,
      borderWidth: 1,
      offset: pieOffset,
      borderColor: pieBorderColor,
      tooltipContainer: this.container
    });
  }

  boxChart($el) {
    let thisBoxWidth = $el.data('sparkline-width') || 'auto';
    let thisBoxHeight = $el.data('sparkline-height') || 'auto';
    let thisBoxRaw = $el.data('sparkline-boxraw');
    let thisBoxTarget = $el.data('sparkline-targetval');
    let thisBoxMin = $el.data('sparkline-min');
    let thisBoxMax = $el.data('sparkline-max');
    let thisShowOutlier = $el.data('sparkline-showoutlier') || true;
    let thisIQR = $el.data('sparkline-outlier-iqr') || 1.5;
    let thisBoxSpotRadius = $el.data('sparkline-spotradius') || 1.5;
    let thisBoxLineColor = $el.css('color') || '#000000';
    let thisBoxFillColor = $el.data('fill-color') || '#c0d0f0';
    let thisBoxWhisColor = $el.data('sparkline-whis-color') || '#000000';
    let thisBoxOutlineColor = $el.data('sparkline-outline-color') || '#303030';
    let thisBoxOutlineFill = $el.data('sparkline-outlinefill-color') || '#f0f0f0';
    let thisBoxMedianColor = $el.data('sparkline-outlinemedian-color') || '#f00000';
    let thisBoxTargetColor = $el.data('sparkline-outlinetarget-color') || '#40a020';

    $el.sparkline('html', {
      type: 'box',
      width: thisBoxWidth,
      height: thisBoxHeight,
      raw: thisBoxRaw,
      target: thisBoxTarget,
      minValue: thisBoxMin,
      maxValue: thisBoxMax,
      showOutliers: thisShowOutlier,
      outlierIQR: thisIQR,
      spotRadius: thisBoxSpotRadius,
      boxLineColor: thisBoxLineColor,
      boxFillColor: thisBoxFillColor,
      whiskerColor: thisBoxWhisColor,
      outlierLineColor: thisBoxOutlineColor,
      outlierFillColor: thisBoxOutlineFill,
      medianColor: thisBoxMedianColor,
      targetColor: thisBoxTargetColor,
      tooltipContainer: this.container

    });
  }

  bulletChart($el) {
    let thisBulletHeight = $el.data('sparkline-height') || 'auto';
    let thisBulletWidth = $el.data('sparkline-width') || 2;
    let thisBulletColor = $el.data('sparkline-bullet-color') || '#ed1c24';
    let thisBulletPerformanceColor = $el.data('sparkline-performance-color') || '#3030f0';
    let thisBulletRangeColors = $el.data('sparkline-bulletrange-color') || ["#d3dafe", "#a8b6ff", "#7f94ff"];

    $el.sparkline('html', {

      type: 'bullet',
      height: thisBulletHeight,
      targetWidth: thisBulletWidth,
      targetColor: thisBulletColor,
      performanceColor: thisBulletPerformanceColor,
      rangeColors: thisBulletRangeColors,
      tooltipContainer: this.container

    });
  }

  discreteChart($el) {
    let thisDiscreteHeight = $el.data('sparkline-height') || 26;
    let thisDiscreteWidth = $el.data('sparkline-width') || 50;
    let thisDiscreteLineColor = $el.css('color');
    let thisDiscreteLineHeight = $el.data('sparkline-line-height') || 5;
    let thisDiscreteThrushold = $el.data('sparkline-threshold');
    let thisDiscreteThrusholdColor = $el.data('sparkline-threshold-color') || '#ed1c24';

    $el.sparkline('html', {
      type: 'discrete',
      width: thisDiscreteWidth,
      height: thisDiscreteHeight,
      lineColor: thisDiscreteLineColor,
      lineHeight: thisDiscreteLineHeight,
      thresholdValue: thisDiscreteThrushold,
      thresholdColor: thisDiscreteThrusholdColor,
      tooltipContainer: this.container
    });
  }

  tristaneChart($el) {
    let thisTristateHeight = $el.data('sparkline-height') || 26;
    let thisTristatePosBarColor = $el.data('sparkline-posbar-color') || '#60f060';
    let thisTristateNegBarColor = $el.data('sparkline-negbar-color') || '#f04040';
    let thisTristateZeroBarColor = $el.data('sparkline-zerobar-color') || '#909090';
    let thisTristateBarWidth = $el.data('sparkline-barwidth') || 5;
    let thisTristateBarSpacing = $el.data('sparkline-barspacing') || 2;
    let thisZeroAxis = $el.data('sparkline-zeroaxis');

    $el.sparkline('html', {
      type: 'tristate',
      height: thisTristateHeight,
      posBarColor: thisTristatePosBarColor,
      negBarColor: thisTristateNegBarColor,
      zeroBarColor: thisTristateZeroBarColor,
      barWidth: thisTristateBarWidth,
      barSpacing: thisTristateBarSpacing,
      zeroAxis: thisZeroAxis,
      tooltipContainer: this.container
    });
  }

  compositeBarChart($el) {
   let sparklineHeight = $el.data('sparkline-height') || '20px';
    let sparklineWidth = $el.data('sparkline-width') || '100%';
    let sparklineBarWidth = $el.data('sparkline-barwidth') || 3;
    let thisLineWidth = $el.data('sparkline-line-width') || 1;
    let thisLineColor = $el.data('sparkline-color-top') || '#ed1c24';
    let thisBarColor = $el.data('sparkline-color-bottom') || '#333333';

    $el.sparkline($el.data('sparkline-bar-val'), {
      type: 'bar',
      width: sparklineWidth,
      height: sparklineHeight,
      barColor: thisBarColor,
      barWidth: sparklineBarWidth,
      tooltipContainer: this.container
      //barSpacing: 5
    });

    $el.sparkline($el.data('sparkline-line-val'), {
      width: sparklineWidth,
      height: sparklineHeight,
      lineColor: thisLineColor,
      lineWidth: thisLineWidth,
      composite: true,
      fillColor: false,
      tooltipContainer: this.container
    });
  }

  compositeLineChart($el) {

    // @todo webpack gets stuck on chunk optimization if uncomment defaults

    let sparklineHeight = $el.data('sparkline-height') // || '20px';
    let sparklineWidth = $el.data('sparkline-width')  // || '90px';
    let sparklineValue = $el.data('sparkline-bar-val');
    let sparklineValueSpots1 = $el.data('sparkline-bar-val-spots-top');
    let sparklineValueSpots2 = $el.data('sparkline-bar-val-spots-bottom');
    let thisLineWidth1 = $el.data('sparkline-line-width-top') //  || 1;
    let thisLineWidth2 = $el.data('sparkline-line-width-bottom')  // || 1;
    let thisLineColor1 = $el.data('sparkline-color-top') //  || '#333333';
    let thisLineColor2 = $el.data('sparkline-color-bottom') //  || '#ed1c24';
    let thisSpotRadius1 = $el.data('sparkline-spotradius-top')  // || 1.5;
    let thisSpotRadius2 = $el.data('sparkline-spotradius-bottom')  // || thisSpotRadius1;
    let thisSpotColor = $el.data('sparkline-spot-color')  // || '#f08000';
    let thisMinSpotColor1 = $el.data('sparkline-minspot-color-top')  // || '#ed1c24';
    let thisMaxSpotColor1 = $el.data('sparkline-maxspot-color-top') //  || '#f08000';
    let thisMinSpotColor2 = $el.data('sparkline-minspot-color-bottom')  // || thisMinSpotColor1;
    let thisMaxSpotColor2 = $el.data('sparkline-maxspot-color-bottom') //  || thisMaxSpotColor1;
    let thishighlightSpotColor1 = $el.data('sparkline-highlightspot-color-top') //  || '#50f050';
    let thisHighlightLineColor1 = $el.data('sparkline-highlightline-color-top')  // || '#f02020';
    let thishighlightSpotColor2 = $el.data('sparkline-highlightspot-color-bottom')  // || thishighlightSpotColor1;
    let thisHighlightLineColor2 = $el.data('sparkline-highlightline-color-bottom')  // || thisHighlightLineColor1;
    let thisFillColor1 = $el.data('sparkline-fillcolor-top')  // || 'transparent';
    let thisFillColor2 = $el.data('sparkline-fillcolor-bottom')  // || 'transparent';

    $el.sparkline(sparklineValue, {

      type: 'line',
      spotRadius: thisSpotRadius1,

      spotColor: thisSpotColor,
      minSpotColor: thisMinSpotColor1,
      maxSpotColor: thisMaxSpotColor1,
      highlightSpotColor: thishighlightSpotColor1,
      highlightLineColor: thisHighlightLineColor1,

      valueSpots: sparklineValueSpots1,

      lineWidth: thisLineWidth1,
      width: sparklineWidth,
      height: sparklineHeight,
      lineColor: thisLineColor1,
      fillColor: thisFillColor1,
      tooltipContainer: this.container

    });

    $el.sparkline($el.data('sparkline-line-val'), {

      type: 'line',
      spotRadius: thisSpotRadius2,

      spotColor: thisSpotColor,
      minSpotColor: thisMinSpotColor2,
      maxSpotColor: thisMaxSpotColor2,
      highlightSpotColor: thishighlightSpotColor2,
      highlightLineColor: thisHighlightLineColor2,

      valueSpots: sparklineValueSpots2,

      lineWidth: thisLineWidth2,
      width: sparklineWidth,
      height: sparklineHeight,
      lineColor: thisLineColor2,
      composite: true,
      fillColor: thisFillColor2,
      tooltipContainer: this.container

    });

  }

  drawSparklines() {
    $('.sparkline:not(:has(>canvas))', this.container).each((i, el) => {
      let $el = $(el),
        sparklineType = $el.data('sparkline-type') || 'bar';

      if (sparklineType == 'bar') {
        this.barChart($el)
      }

      if (sparklineType == 'line') {
        this.lineChart($el)
      }

      if (sparklineType == 'pie') {
        this.pieChart($el)
      }

      if (sparklineType == 'box') {
        this.boxChart($el)
      }

      if (sparklineType == 'bullet') {
        this.bulletChart($el)
      }

      if (sparklineType == 'discrete') {
        this.discreteChart($el)
      }

      if (sparklineType == 'tristate') {
        this.tristaneChart($el)
      }

      if (sparklineType == 'compositebar') {
        this.compositeBarChart($el)
      }

      if (sparklineType == 'compositeline') {
        this.compositeLineChart($el)
      }

    });
  }
}
