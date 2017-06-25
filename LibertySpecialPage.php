<?php
// @codingStandardsIgnoreLine
class LibertySpecialPage extends SpecialPage
{
    public function __construct()
    {
        parent::__construct('Liberty');
    }

    public function execute($par)
    {
        $request = $this->getRequest();
        $output = $this->getOutput();
        $this->setHeaders();

        $param = $request->getText( 'param' );

        $output->setPageTitle(wfMessage('liberty-sp-title')->plain());
        $output->addHTML($this->body());
    }

    /* Protected Function here */

    protected function body()
    {
    }
}
