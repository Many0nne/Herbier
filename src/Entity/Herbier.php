<?php

namespace App\Entity;

use App\Repository\HerbierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HerbierRepository::class)]
class Herbier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $Releve = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(length: 255)]
    private ?string $Lieu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getReleve(): array
    {
        return $this->Releve;
    }

    public function setReleve(array $Releve): static
    {
        $this->Releve = $Releve;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->Lieu;
    }

    public function setLieu(string $Lieu): static
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function generateTable(): array
    {
        $table = []; // La table de l'herbier
        $releve = $this->getReleve(); // Le relevé de l'herbier

        if (!is_array($releve) || count($releve) !== 9) { //si $releve n'est pas un tableau ou s'il ne contient pas 9 éléments (c'est obligatoire)
            return $table;
        }

        $releve = array_map(fn($x) => (int) $x, $releve); // Convertit tous les éléments du tableau en entiers

        for ($i = 0; $i < 3; $i++) { // Pour chaque ligne
            $table[$i] = []; // Crée un tableau vide
            for ($j = 0; $j < 3; $j++) { // Pour chaque colonne
                $table[$i][$j] = []; // Crée un tableau vide
                $indices = range(0, 8); // Crée un tableau avec les indices de 0 à 8
                shuffle($indices); // Mélange les indices

                for ($k = 0; $k < $releve[$i * 3 + $j]; $k++) { // Pour chaque élément du relevé
                    $index = $indices[$k]; // Prend l'indice correspondant
                    $table[$i][$j][] = $index; // Ajoute l'indice au tableau
                }
            }
        }

        return $table;
    }

}
