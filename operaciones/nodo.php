<?php
class Nodo
{
    private string $valor;
    private ?Nodo $izquierda;
    private ?Nodo $derecha;

    //creacion de nodos
    public function __construct(string $valor, ?Nodo $izquierda = null, ?Nodo $derecha = null)
    {
        $this->valor = $valor;
        $this->izquierda = $izquierda;
        $this->derecha = $derecha;
    }

    public function getValor() //lee el valor
    {
        return $this->valor;
    }
    public function setValor(string $valor) //cambia
    {
        $this->valor = $valor;
    }
    //devuelve asigna
    public function getIzquierda()
    {
        return $this->izquierda;
    }
    public function setIzquierda(?Nodo $valor = null)
    {
        $this->izquierda = $valor;
    }
    public function getDerecha()
    {
        return $this->derecha;
    }
    public function setDerecha(?Nodo $valor = null)
    {
        $this->derecha = $valor;
    }

    //imprimenodo N ,I y D
    public function preorden()
    {
        echo "<h2 class=subtitulo>$this->valor</h2>";
        if ($this->izquierda != null) {
            $this->izquierda->preorden();
        }
        if ($this->derecha != null) {
            $this->derecha->preorden();
        }
    }
    //imprimenodo I ,N y D
    public function inorden()
    {
        if ($this->izquierda != null) {
            $this->izquierda->inorden();
        }
        echo "<h2 class=subtitulo>$this->valor</h2>";
        if ($this->derecha != null) {
            $this->derecha->inorden();
        }
    }
    //imprimenodo I ,D y N
    public function postorden()
    {
        if ($this->izquierda != null) {
            $this->izquierda->postorden();
        }
        if ($this->derecha != null) {
            $this->derecha->postorden();
        }
        echo "<h2 class=subtitulo>$this->valor</h2>";
    }
}
