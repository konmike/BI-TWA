<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 17.10.18
 * Time: 11:40
 */

namespace App;

use App\Model\Database;


class Router
{
    /** @var Database */
    protected $database;

    /** @var \Twig_Environment */
    protected $twig;

    /**
     * Router constructor.
     * @param Database $database
     * @param \Twig_Environment $twig
     */
    public function __construct ( Database $database, \Twig_Environment $twig )
    {
        $this->database = $database;
        $this->twig = $twig;
    }

    public function process ( $parameters ): string
    {
        $page = $this->getParameter($parameters, 'page', 'index');

        switch ( $page ) {
            case 'index':
                return $this->routeIndex();
            case 'list':
                return $this->routeList();
            case 'detail':
                $id = $this->getParameter($parameters, 'id');
                return $this->routeDetail($id);
            case 'edit':
                $id = $this->getParameter($parameters, 'id');
                return $this->routeEdit($id);
            default:
                return $this->routeNotFound();
        }
    }

    protected function getParameter ( $array, $key, $default = null )
    {
        if ( array_key_exists($key, $array) )
            return $array[ $key ];
        return $default;
    }

    protected function routeIndex (): string
    {
        $employees = $this->database->getEmployees();
        return $this->twig->render('index.html.twig', array('employees' => $employees));
    }

    protected function routeList (): string
    {
        $employees = $this->database->getEmployees();
        return $this->twig->render('list.html.twig', array('employees' => $employees));
    }

    protected function routeInternalServerError ( \Throwable $ex ): string
    {
        return $this->twig->render('500.html.twig');
    }

    protected function routeDetail ( $id ): string
    {
        $employee = $this->database->getEmployee($id);
        return $this->twig->render('detail.html.twig', array('employee' => $employee));
    }

    protected function routeNotFound (): string
    {
        return $this->twig->render('404.html.twig');
    }

    protected function routeEdit ( $id ): string
    {
        $employee = $this->database->getEmployee($id);
        return $this->twig->render('edit.html.twig', array('employee' => $employee));
    }


}

