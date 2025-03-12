/* hey everyone, just added this file to store code that has been removed from other pages that
i didn't write so that it's not totally gone */

// from the index pages
<!-- https://getbootstrap.com/docs/5.3/components/card/ -->
<?php include 'retrieve_dance.php';?>
<section class="popular-dances py-5">
    <div class="container">
        <h2 class="text-center mb-4">Popular Dances</h2>
        <p class="text-center text-muted mb-5">Some of the most searched dances around the world</p>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach($result_rows as $row) {?>
            <div class="col">
                <div class="card shadow-sm h-100">
                    <div class="card-body">

                    <h5 class="card-title"><!--Dance Name 1--> <?php echo $row["name"] ?> </h5>
                    <p class="card-text"><!--A brief description of what makes this dance unique.--> <?php echo $row["description"]?></p>

                    <?php if (isset($row["link"])) {?>
                        <iframe src= <?php echo $row["link"]?>></iframe>
                    <?php
                    }
                    ?>
                    <?php if ($row["image"]) {?>
                        <img src="<?php echo "data:".$row["MimeType"].";base64," . base64_encode($row["image"]) ?>" Height="30%" Style="width:auto">
                    <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
</section>