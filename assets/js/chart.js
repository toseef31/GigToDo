demo = {
  initPickColor: function() {
    $('.pick-class-label').click(function() {
      var new_class = $(this).attr('new-class');
      var old_class = $('#display-buttons').attr('data-class');
      var display_div = $('#display-buttons');
      if (display_div.length) {
        var display_buttons = display_div.find('.btn');
        display_buttons.removeClass(old_class);
        display_buttons.addClass(new_class);
        display_div.attr('data-class', new_class);
      }
    });
  },

  initDocChart: function() {
    chartColor = "#FFFFFF";
  
    ctx = document.getElementById('chartHours').getContext("2d");
  
    myChart = new Chart(ctx, {
      type: 'line',
  
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
        datasets: [{
            borderColor: "#6bd098",
            backgroundColor: "#6bd098",
            pointRadius: 0,
            pointHoverRadius: 0,
            borderWidth: 3,
            data: [30, 31, 31, 32, 33, 32, 33, 34, 33, 35]
          },
          {
            borderColor: "#f17e5d",
            backgroundColor: "#f17e5d",
            pointRadius: 0,
            pointHoverRadius: 0,
            borderWidth: 3,
            data: [320, 340, 365, 360, 370, 385, 390, 384, 408, 420]
          },
          {
            borderColor: "#fcc468",
            backgroundColor: "#fcc468",
            pointRadius: 0,
            pointHoverRadius: 0,
            borderWidth: 3,
            data: [370, 394, 415, 409, 425, 445, 460, 450, 478, 484]
          }
        ]
      },
      options: {
        legend: {
          display: false
        },
  
        tooltips: {
          enabled: false
        },
  
        scales: {
          yAxes: [{
  
            ticks: {
              fontColor: "#9f9f9f",
              beginAtZero: false,
              maxTicksLimit: 5,
              //padding: 20
            },
            gridLines: {
              drawBorder: false,
              zeroLineColor: "#ccc",
              color: 'rgba(255,255,255,0.05)'
            }
  
          }],
  
          xAxes: [{
            barPercentage: 1.6,
            gridLines: {
              drawBorder: false,
              color: 'rgba(255,255,255,0.1)',
              zeroLineColor: "transparent",
              display: false,
            },
            ticks: {
              padding: 20,
              fontColor: "#9f9f9f"
            }
          }]
        },
      }
    });
  
  },

  initChartsPages: function() {
    chartColor = "#FFFFFF";

    ctx_line = document.getElementById('chartHours').getContext("2d");

    $(document).ready(function(){
      $.ajax({
        url: "/dashboard/get_partners",
        success: function (response) {
          var res = JSON.parse(response);
          var nov = res.nov;
          var dec = res.dec;
          var jan = res.jan;
          var feb = res.feb;
          var mar = res.mar;
          var apr = res.apr;
          var may = res.may;
          var jun = res.jun;
          var jul = res.jul;
          var aug = res.aug;
          var sep = res.sep;
          var oct = res.oct;
          console.log(nov);
          myChart = new Chart(ctx_line, {
            type: 'line',

            data: {
              labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
              datasets: [{
                  borderColor: "#6bd098",
                  backgroundColor: "#6bd098",
                  pointRadius: 0,
                  pointHoverRadius: 0,
                  borderWidth: 3,
                  data: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct]
                },

              ]
            },
            options: {
              legend: {
                display: false
              },

              tooltips: {
                enabled: false
              },

              scales: {
                yAxes: [{

                  ticks: {
                    fontColor: "#9f9f9f",
                    beginAtZero: false,
                    maxTicksLimit: 5,
                    //padding: 20
                  },
                  gridLines: {
                    drawBorder: false,
                    zeroLineColor: "#ccc",
                    color: 'rgba(255,255,255,0.05)'
                  }

                }],

                xAxes: [{
                  barPercentage: 1.6,
                  gridLines: {
                    drawBorder: false,
                    color: 'rgba(255,255,255,0.1)',
                    zeroLineColor: "transparent",
                    display: false,
                  },
                  ticks: {
                    padding: 20,
                    fontColor: "#9f9f9f"
                  }
                }]
              },
            }
          });

        }
      });
    });


    ctx = document.getElementById('chartEmail').getContext("2d");

    $(document).ready(function(){
      $.ajax({
        url: "/dashboard/get_quote_status",
        success: function (response) {
          var res = JSON.parse(response);
          var pending = res.pending;
          var won = res.won;
          var rejected = res.rejected;
          // console.log(pending);
          myChart = new Chart(ctx, {
            type: 'pie',
            data: {
              labels: [won, pending, rejected],
              datasets: [{
                label: "Emails",
                pointRadius: 0,
                pointHoverRadius: 0,
                backgroundColor: [
                  '#4acccd',
                  '#fcc468',
                  '#ef8157'
                ],
                borderWidth: 0,
                // data: [750, 500, 250]
                data: [won, pending, rejected]
              }]
            },

            options: {

              legend: {
                display: true
              },

              pieceLabel: {
                render: 'percentage',
                fontColor: ['white'],
                precision: 2
              },

              tooltips: {
                enabled: false
              },

              scales: {
                yAxes: [{

                  ticks: {
                    display: false
                  },
                  gridLines: {
                    drawBorder: false,
                    zeroLineColor: "transparent",
                    color: 'rgba(255,255,255,0.05)'
                  }

                }],

                xAxes: [{
                  barPercentage: 1.6,
                  gridLines: {
                    drawBorder: false,
                    color: 'rgba(255,255,255,0.1)',
                    zeroLineColor: "transparent"
                  },
                  ticks: {
                    display: false,
                  }
                }]
              },
            }
          });

        }
      });
    });


    var speedCanvasCompany = document.getElementById("speedChartCompany");

    var dataFirst = {
      data: [0, 19, 15, 20, 30, 40, 40, 50, 25, 30, 50, 70],
      fill: false,
      borderColor: '#fbc658',
      backgroundColor: 'transparent',
      pointBorderColor: '#fbc658',
      pointRadius: 4,
      pointHoverRadius: 4,
      pointBorderWidth: 8,
    };

    var dataSecond = {
      data: [0, 5, 10, 12, 20, 27, 30, 34, 42, 45, 55, 63],
      fill: false,
      borderColor: '#51CACF',
      backgroundColor: 'transparent',
      pointBorderColor: '#51CACF',
      pointRadius: 4,
      pointHoverRadius: 4,
      pointBorderWidth: 8
    };

    var speedData = {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [dataFirst, dataSecond]
    };

    var chartOptions = {
      legend: {
        display: false,
        position: 'top'
      }
    };

    var lineChart = new Chart(speedCanvasCompany, {
      type: 'line',
      hover: false,
      data: speedData,
      options: chartOptions
    });

    var speedCanvas = document.getElementById("speedChart");
    $(document).ready(function(){
      // alert("asdf");
      $.ajax({
        url: "/dashboard/get_payments",
        success: function (response) {
          console.log(response);
          var res = JSON.parse(response);
          var jan = res.jan;
          var feb = res.feb;
          var mar = res.mar;
          var apr = res.apr;
          var may = res.may;
          var jun = res.jun;
          var jul = res.jul;
          var aug = res.aug;
          var sep = res.sep;
          var oct = res.oct;
          var nov = res.nov;
          var dec = res.dec;
          var jan2 = res.jans;
          var feb2 = res.febs;
          var mar2 = res.mars;
          var apr2 = res.aprs;
          var may2 = res.mays;
          var jun2 = res.juns;
          var jul2 = res.juls;
          var aug2 = res.augs;
          var sep2 = res.seps;
          var oct2 = res.octs;
          var nov2 = res.novs;
          var dec2 = res.decs;
          console.log(nov);

          var dataFirst = {
            data: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec],
            fill: false,
            borderColor: '#51CACF',
            backgroundColor: 'transparent',
            pointBorderColor: '#51CACF',
            pointRadius: 4,
            pointHoverRadius: 4,
            pointBorderWidth: 8,
          };
          var dataSecond = {
            data: [jan2, feb2, mar2, apr2, may2, jun2, jul2, aug2, sep2, oct2, nov2, dec2],
            // data: [0, 5, 10, 12, 20, 27, 30, 34, 42, 45, 55, 63],
            fill: false,
            borderColor: '#fbc658',
            backgroundColor: 'transparent',
            pointBorderColor: '#fbc658',
            pointRadius: 4,
            pointHoverRadius: 4,
            pointBorderWidth: 8
          };

          var speedData = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [dataFirst,dataSecond]
          };

          var chartOptions = {
            legend: {
              display: false,
              position: 'top'
            }
          };

          var lineChart = new Chart(speedCanvas, {
            type: 'line',
            hover: false,
            data: speedData,
            options: chartOptions
          });

        }
      });
    });
    // var dataFirst = {
    //   data: [0, 19, 15, 20, 30, 40, 40, 50, 25, 30, 50, 70],
    //   fill: false,
    //   borderColor: '#fbc658',
    //   backgroundColor: 'transparent',
    //   pointBorderColor: '#fbc658',
    //   pointRadius: 4,
    //   pointHoverRadius: 4,
    //   pointBorderWidth: 8,
    // };
    //
    // var dataSecond = {
    //   data: [0, 5, 10, 12, 20, 27, 30, 34, 42, 45, 55, 63],
    //   fill: false,
    //   borderColor: '#51CACF',
    //   backgroundColor: 'transparent',
    //   pointBorderColor: '#51CACF',
    //   pointRadius: 4,
    //   pointHoverRadius: 4,
    //   pointBorderWidth: 8
    // };
    //
    // var speedData = {
    //   labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    //   datasets: [dataFirst, dataSecond]
    // };
    //
    // var chartOptions = {
    //   legend: {
    //     display: false,
    //     position: 'top'
    //   }
    // };
    //
    // var lineChart = new Chart(speedCanvas, {
    //   type: 'line',
    //   hover: false,
    //   data: speedData,
    //   options: chartOptions
    // });
  },
// End Chart function
  initGoogleMaps: function() {
    var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
    var mapOptions = {
      zoom: 13,
      center: myLatlng,
      scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
      styles: [{
        "featureType": "water",
        "stylers": [{
          "saturation": 43
        }, {
          "lightness": -11
        }, {
          "hue": "#0088ff"
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [{
          "hue": "#ff0000"
        }, {
          "saturation": -100
        }, {
          "lightness": 99
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#808080"
        }, {
          "lightness": 54
        }]
      }, {
        "featureType": "landscape.man_made",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#ece2d9"
        }]
      }, {
        "featureType": "poi.park",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#ccdca1"
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [{
          "color": "#767676"
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.stroke",
        "stylers": [{
          "color": "#ffffff"
        }]
      }, {
        "featureType": "poi",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "landscape.natural",
        "elementType": "geometry.fill",
        "stylers": [{
          "visibility": "on"
        }, {
          "color": "#b8cb93"
        }]
      }, {
        "featureType": "poi.park",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.sports_complex",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.medical",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.business",
        "stylers": [{
          "visibility": "simplified"
        }]
      }]

    }
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var marker = new google.maps.Marker({
      position: myLatlng,
      title: "Hello World!"
    });

    // To add the marker to the map, call setMap();
    marker.setMap(map);
  },

  showNotification: function(from, align) {
    color = 'primary';

    $.notify({
      icon: "nc-icon nc-bell-55",
      message: "Welcome to <b>Paper Dashboard</b> - a beautiful bootstrap dashboard for every web developer."

    }, {
      type: color,
      timer: 8000,
      placement: {
        from: from,
        align: align
      }
    });
  }

};
