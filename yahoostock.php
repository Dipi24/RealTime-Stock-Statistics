<?php
/**
 * Class to fetch stock data from Yahoo! Finance
 *
 */
	class Company
	{
		public $code;
		public $name;
		public $price;
		public $change;
		public $lateDate;
		public $lastTime;
		
		
	}
    class YahooStock {

        /**
         * Array of stock code
         */
        private $stocks = array();

        /**
         * Parameters string to be fetched  
         */
        private $format;
		
		public $objectResult = array();			
        

        /**
         * Populate stock array with stock code
         *
         * @param string $stock Stock code of company   
         * @return void
         */
        public function addStock($stock)
        {
            $this->stocks[] = $stock;
        }

        /**
         * Populate parameters/format to be fetched
         *
         * @param string $param Parameters/Format to be fetched
         * @return void
         */
        public function addFormat($format)
        {
            $this->format = $format;
        }

        /**
         * Get Stock Data
         *
         * @return array
         */
        public function getQuotes()
        {       
            $result = array();    
		    $format = $this->format;

            foreach ($this->stocks as $stock)
            {           
                /**
                 * fetch data from Yahoo!
                 * s = stock code
                 * f = format
                 * e = filetype
                 */
                $s = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=$stock&f=$format&e=.csv");

                /**
                 * convert the comma separated data into array
                 */
                $data = explode( ',', $s);

                /**
                 * populate result array with stock code as key
                 */
				 
				 $myobj = new Company();
		
				 $myobj->code = $data[0];
				 $myobj->name = $data[1];
				 $myobj->price = $data[2];
				 $myobj->lateDate = $data[3];
				 $myobj->lastTime = $data[4];
				 $myobj->change = $data[5]; 
					 
			
                $result[$stock] = $data;
				$objectResult[] = $myobj;
            }
            return $result;
        }
    }
    $objYahooStock = new YahooStock;

    /**
        Add format/parameters to be fetched

        s = Symbol
        n = Name
        l1 = Last Trade (Price Only)
        d1 = Last Trade Date
        t1 = Last Trade Time
        c = Change and Percent Change
        v = Volume
     */
	 
	/* $con = mysql_connect("localhost", "root", "123");
	if (!$con)
	  {
  		  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db("companystock", $con);
	*/
    $objYahooStock->addFormat("snl1d1t1cv");

    /**
        Add company stock code to be fetched

        msft = Microsoft
        amzn = Amazon
        yhoo = Yahoo
        goog = Google
        aapl = Apple   
     */
    $objYahooStock->addStock("hpq");
    $objYahooStock->addStock("yhoo");
    $objYahooStock->addStock("goog");
    $objYahooStock->addStock("vgz");
    /**
     * Printing out the data
     */
    ?>
	<script src="css/bootstrap.css" type="text/css"></script>
    <table class="table table-bordered">
			<thead>
				<tr>
	    <th width="15%">Code</th>
        <th width="15%">Name</th>
        <th width="15%">Last Trade Price</th>
		<th width="15%">Last Trade Date</th>
        <th width="15%">Last Trade Time</th>
        <th width="15%">Change and Percent Change</th>
      		</tr>
			</thead>
			<tbody>
    <?php
    foreach( $objYahooStock->getQuotes() as $code => $stock)
    {	
	    ?>
        <tr>
				
            <td align="center"><?php echo $stock[0]; ?></td>
            <td align="center"><?php echo $stock[1]; ?></td>
            <td align="center"><?php echo $stock[2]; ?></td>
            <td align="center"><?php echo $stock[3]; ?></td>
            <td align="center"><?php echo $stock[4]; ?></td>
            <td align="center"><?php echo $stock[5]; ?></td>
                 </tr>

        <?php
    }
?>
    </table>