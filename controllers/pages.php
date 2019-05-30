<?php
/**
 *
 */
class Pages extends Controller
{
  protected function Contact()
  {
    $viewModel = new PagesModel;
    $this->ReturnView($viewModel->Contact(), true);
  }
}
