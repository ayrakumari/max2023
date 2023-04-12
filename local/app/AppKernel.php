<?php
// app/AppKernel.php

class AppKernel extends Kernel
{
    // ..

    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Khill\Lavacharts\Symfony\Bundle\LavachartsBundle(),
        );
    }
}
