<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
	 * @Assert\Length(min=10)
     */
    private $contenu;

	/**
	* @ORM\ManyToOne(targetEntity="App\Entity\Materiel", inversedBy="comment")
	*/
	private $materiel;
  
	public function setMateriel(?Materiel $materiel): self
	{
		$this->materiel = $materiel;

		return $this;
	}

	public function getMateriel(): ?Materiel
	{
		return $this->materiel;
	}
	
  
	/**
     * @ORM\Column(type="integer")
     */
	private $materiel_id;
  
	public function setMaterielId($materielid)
	{
		$this->materiel_id = $materielid;

		return $this;
	}

	public function getMaterielId()
	{
		return $this->materiel_id;
	}
  
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }
	
	/**
	* @Gedmo\Slug(fields={"titre"})
	* @ORM\Column(name="slug", type="string", length=255, unique=true)
	*/
	private $slug;
  
  
	public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
