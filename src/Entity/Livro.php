<?php

namespace App\Entity;

use App\Repository\LivroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: LivroRepository::class)]
#[UniqueEntity(fields: ['Titulo'], message: 'Já existe um livro cadastrado com este título.')]
class Livro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'Codl', type: 'integer')]
    private ?int $Codl = null;

    #[ORM\Column(name: 'Titulo', type: 'string', length: 40)]
    private ?string $Titulo = null;

    #[ORM\Column(name: 'Editora', type: 'string', length: 40)]
    private ?string $Editora = null;

    #[ORM\Column(name: 'Edicao', type: 'integer')   ]
    private ?int $Edicao = null;

    #[ORM\Column(name: 'AnoPublicacao', type: 'string', length: 4)]
    private ?string $AnoPublicacao = null;

    /**
     * @var Collection<int, Autor>
     */
    #[ORM\ManyToMany(targetEntity: Autor::class, inversedBy: 'livros')]
    #[ORM\JoinTable(
        name: 'Livro_Autor',
        joinColumns: [
            new ORM\JoinColumn(name: 'Livro_Codl', referencedColumnName: 'Codl', onDelete: 'CASCADE')
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'Autor_CodAu', referencedColumnName: 'CodAu', onDelete: 'RESTRICT')
        ]
    )]
    private Collection $autores;

    /**
     * @var Collection<int, Assunto>
     */
    #[ORM\ManyToMany(targetEntity: Assunto::class, inversedBy: 'livros')]
    #[ORM\JoinTable(
        name: 'Livro_Assunto',
        joinColumns: [
            new ORM\JoinColumn(name: 'Livro_Codl', referencedColumnName: 'Codl', onDelete: 'CASCADE')
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'Assunto_codAs', referencedColumnName: 'codAs', onDelete: 'RESTRICT')
        ]
    )]
    private Collection $assuntos;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $Valor = null;

    public function __construct()
    {
        $this->autores = new ArrayCollection();
        $this->assuntos = new ArrayCollection();
    }

    public function getCodl(): ?int
    {
        return $this->Codl;
    }

    public function getTitulo(): ?string
    {
        return $this->Titulo;
    }

    public function setTitulo(string $Titulo): static
    {
        $this->Titulo = $Titulo;

        return $this;
    }

    public function getEditora(): ?string
    {
        return $this->Editora;
    }

    public function setEditora(string $Editora): static
    {
        $this->Editora = $Editora;

        return $this;
    }

    public function getEdicao(): ?int
    {
        return $this->Edicao;
    }

    public function setEdicao(int $Edicao): static
    {
        $this->Edicao = $Edicao;

        return $this;
    }

    public function getAnoPublicacao(): ?string
    {
        return $this->AnoPublicacao;
    }

    public function setAnoPublicacao(string $AnoPublicacao): static
    {
        $this->AnoPublicacao = $AnoPublicacao;

        return $this;
    }

    /**
     * @return Collection<int, Autor>
     */
    public function getAutores(): Collection
    {
        return $this->autores;
    }

    public function addAutor(Autor $autor): static
    {
        if (!$this->autores->contains($autor)) {
            $this->autores->add($autor);
            $autor->addLivro($this);
        }

        return $this;
    }

    public function removeAutor(Autor $autor): static
    {
        if ($this->autores->removeElement($autor)) {
            $autor->removeLivro($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Assunto>
     */
    public function getAssuntos(): Collection
    {
        return $this->assuntos;
    }

    public function addAssunto(Assunto $assunto): static
    {
        if (!$this->assuntos->contains($assunto)) {
            $this->assuntos->add($assunto);
        }

        return $this;
    }

    public function removeAssunto(Assunto $assunto): static
    {
        $this->assuntos->removeElement($assunto);

        return $this;
    }

    public function getValor(): ?string
    {
        return $this->Valor;
    }

    public function setValor(string $Valor): static
    {
        $this->Valor = $Valor;

        return $this;
    }
}
