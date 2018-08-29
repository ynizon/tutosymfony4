<?php

namespace App\Entity;
use App\Traits\Formattage;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MaterielRepository")
 */
class Materiel
{
	use Formattage;
	
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

	/**
	* @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="materiel", cascade={"persist"}, orphanRemoval=true)
	*/
	
	//cascade = persist (fait les modifs en cascade)
	//orphanRemoval ne permet pas qu'un objet avec un materiel_id null reste en base
	
	private $comment; // Notez le « s », une annonce est liée à plusieurs commentaires

    public function __construct()
    {
        $this->comment = new ArrayCollection();
    }
	
	public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setComment($this);
        }

        return $this;
    }
	
	public function removeComment(Comment $comment): self
    {
        if ($this->comment->contains($comment)) {
            $this->comment->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getMateriel() === $this) {
                $comment->setMateriel(null);//Necessite le orphanRemoval
            }
        }

        return $this;
    }
	
	
	public function getComments()
    {
        return $this->comment;
    }

    public function setComment($comments)
    {
        return $this->comment = $comments;
    }
  
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Titre($this->nom);
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }
}
