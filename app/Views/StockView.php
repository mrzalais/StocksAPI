<h1>Stocks</h1>

<?php if ($stock): ?>
    <h2>Name: <b><?php echo $stock->name(); ?></b></h2>
    <hr/>
    <p>Regular Market Price <b><?php echo $stock->regularMarketPrice(); ?></b></p>
    <p>Regular Market Previous Close <b><?php echo $stock->regularMarketPreviousClose(); ?></b></p>
    <p>Regular Market Open <b><?php echo $stock->regularMarketOpen(); ?></b></p>
    <p>Ask <b><?php echo $stock->ask(); ?></b></p>
    <p>Day range <b><?php echo $stock->dayRange(); ?></b></p>
    <p>52 week range <b><?php echo $stock->fiftyTwoWeekRange(); ?></b></p>
    <p>Volume <b><?php echo $stock->volume(); ?></b></p>
    <p>Average volume <b><?php echo $stock->averageVolume(); ?></b></p>
<?php endif ?>

