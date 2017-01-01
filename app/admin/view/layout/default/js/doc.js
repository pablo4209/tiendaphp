    $(function(){	
        $(document).ready(function(){
                //primero se inicializan los dtp
                $("#txtDesde,#txtHasta").datepicker({
                          showOn: 'both',
                          buttonImage: 'view/layout/default/img/calendar.png',
                          buttonImageOnly: true,					  
                          changeYear: true,
                          numberOfMonths: 2,
                          maxDate: "today"
                });				
                var d = new Date();
                d.setDate(1);
                $("#txtDesde").datepicker("setDate", d); //asignar fechas
                $("#txtHasta").datepicker("setDate", new Date());					


                $("#txtDesde,#txtHasta").change(function() {               
                         $("#tabla").trigger("update");                                                        
                  });
                $("[id*=idTipoDoc]").click(function() {                       
                       $("#tabla").trigger("update");                       
                });  
            
                                
                
            $("#tabla").tablesorter({                        
                        theme : 'blue',
                        widgets: ["zebra"],
                        headers : { 6 : { sorter: false } }
            })        
            .tablesorterPager({                  
              container: $('.pager'),
              ajaxUrl : $("#base_path").val()+'?accion=doc-ajax&page={page}&size={size}&{sortList:column}',
              // modify the url after all processing has been applied
              customAjaxUrl: function(table, url) {
                  // manipulate the url string as you desire
                  // url += '&cPage=' + window.location.pathname;
                  // trigger my custom event                  
                  $(table).trigger('changingUrl', url);
                  var dataString = $('#form').serialize();                  
                  // send the server the current page                  
                  url = url+"&"+dataString; 
                  //alert (url);
                  return url;
              },
        
              ajaxObject: {
                dataType: 'json'
              },
              ajaxProcessing: function(data){
                if (data && data.hasOwnProperty('rows')) {                  
                  var r, row, c, d = data.rows,                  
                  // total number of rows (required)                  
                  total = data.total_rows,
                  // array of header names (optional)
                  headers = data.headers,
                  // all rows: array of arrays; each internal array has the table cell data for that row
                  rows = [],
                  // len should match pager set size (c.size)
                  len = d.length;  
                  // this will depend on how the json is set up - see City0.json
                  // rows                  
                  for ( r=0; r < len; r++ ) {
                    row = []; // new row array
                    // cells
                    var x=1, idprod;
                    for ( c in d[r] ) {                      
                      if (typeof(c) === "string" ) {
                        if( x === 1)//como primer elemento en formato json recibe el idproducto
                        {                            
                            idprod = d[r][c];                            
                        }
			row.push(d[r][c]); // add each table cell data to row array    
                        
                        x=x+1;                        
                      }                      
                    }
                    if(len && idprod>0){
                        row.push('<a href="'+$("#base_path").val()+'?accion=doc-edit&id='+idprod+'" title="Editar Producto"><img src="'+$("#img_path").val()+'b_edit.png" border="0" width="16" height="16"></a>'); //interceptar valor idProducto para que no lo muestre y crear vinculo
                        
                    }
                    rows.push(row); // add new row array to rows array
                  }
                  // in version 2.10, you can optionally return $(rows) a set of table rows within a jQuery object                  
                  return [ total, rows, headers ];
                }
              },        
              // output string - default is '{page}/{totalPages}'; possible variables: {page}, {totalPages}, {startRow}, {endRow} and {totalRows}
              output: '{startRow} to {endRow} ({totalRows})',        
              // apply disabled classname to the pager arrows when the rows at either extreme is visible - default is true
              updateArrows: true,        
              // starting page of the pager (zero based index)
              page: 0,        
              // Number of visible rows - default is 10
              size: 50,        
              // if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
              // table row set to a height to compensate; default is false
              fixedHeight: false,        
              // remove rows from the table to speed up the sort of large tables.
              // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
              removeRows: false,        
              // css class names of pager arrows
              cssNext        : '.next',  // next page arrow
              cssPrev        : '.prev',  // previous page arrow
              cssFirst       : '.first', // go to first page arrow
              cssLast        : '.last',  // go to last page arrow
              cssGoto        : '.gotoPage',
              cssPageDisplay : '.pagedisplay', // location of where the "output" is displayed
              cssPageSize    : '.pagesize', // page size selector - select dropdown that sets the "size" option
              cssErrorRow    : 'tablesorter-errorRow', // error information row        
              // class added to arrows when at the extremes (i.e. prev/first arrows are "disabled" when on the first page)
              cssDisabled    : 'disabled' // Note there is no period "." in front of this class name        
            });



        });						
    }); 