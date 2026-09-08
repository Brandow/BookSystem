<?php

namespace App\Entity;

use App\Repository\AutorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AutorRepository::class)]
#[UniqueEntity(fields: ['Nome'], message: 'Já existe um autor cadastrado com este nome.')]
class Autor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'CodAu', type: 'integer')]
    private ?int $CodAu = null;

    #[ORM\Column(name: 'Nome', type: 'string', length: 40)]
    private ?string $Nome = null;

    /**
     * @var Collection<int, Livro>
     */
    #[ORM\ManyToMany(targetEntity: Livro::class, mappedBy: 'autores')]
    private Collection $livros;

    public function __construct()
    {
        $this->livros = new ArrayCollection();
    }

    public function getCodAu(): ?int
    {
        return $this->CodAu;
    }

    public function getNome(): ?string
    {
        return $this->Nome;
    }

    public function setNome(string $Nome): static
    {
        $this->Nome = $Nome;

        return $this;
    }

    /**
     * @return Collection<int, Livro>
     */
    public function getLivros(): Collection
    {
        return $this->livros;
    }

    public function addLivro(Livro $livro): static
    {
        if (!$this->livros->contains($livro)) {
            $this->livros->add($livro);
        }

        return $this;
    }

    public function removeLivro(Livro $livro): static
    {
        $this->livros->removeElement($livro);

        return $this;
    }

    public function getQtdLivros(): int
    {
        return $this->livros->count();
    }
}
