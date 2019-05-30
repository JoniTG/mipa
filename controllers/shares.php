<?php
/**
 *
 */
class Shares extends Controller
{
  protected function Index()
  {
    $viewModel = new ShareModel;
    $this->ReturnView($viewModel->Index(), true);
  }

  protected function add()
  {
    $viewModel = new ShareModel;
    $this->ReturnView($viewModel->add(), true);
  }
}
