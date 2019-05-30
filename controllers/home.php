<?php
/**
 *
 */
class Home extends Controller
{
  protected function Index()
  {
    $viewModel = new HomeModel;
    $this->ReturnView($viewModel->Index(), true);
  }
}
