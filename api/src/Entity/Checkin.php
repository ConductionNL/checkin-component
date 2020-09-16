<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * An entity representing an checkin.
 *
 * A checkin logs (for a fix time) the pressense of a person at a node
 *
 * @author Ruben van der Linde <ruben@conduction.nl>
 *
 * @category entity
 *
 * @license EUPL <https://github.com/ConductionNL/betaalservice/blob/master/LICENSE.md>
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
 *     itemOperations={
 *          "get",
 *          "put",
 *          "delete",
 *          "get_change_logs"={
 *              "path"="/checkins/{id}/change_log",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Changelogs",
 *                  "description"="Gets al the change logs for this resource"
 *              }
 *          },
 *          "get_audit_trail"={
 *              "path"="/checkins/{id}/audit_trail",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Audittrail",
 *                  "description"="Gets the audit trail for this resource"
 *              }
 *          }
 *     },
 *     collectionOperations={
 *          "get",
 *          "post"
 *     }
 * )
 * @ORM\Entity(repositoryClass=App\Repository\CheckinRepository::class)
 * @Gedmo\Loggable(logEntryClass="Conduction\CommonGroundBundle\Entity\ChangeLog")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="checkin_reference", columns={"reference"})})
 *
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(DateFilter::class, strategy=DateFilter::EXCLUDE_NULL)
 * @ApiFilter(SearchFilter::class)
 */
class Checkin
{
    /**
     * @var UuidInterface The UUID identifier of this object
     *
     * @example e2984465-190a-4562-829e-a8cca81aa35d
     *
     *
     * @Groups({"read"})
     * @Assert\Uuid
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @var string The human readable id for this node
     *
     * @Gedmo\Versioned
     *
     * @example Q32-AD8
     * @Groups({"read"})
     * @Assert\Length(
     *     max=255
     * )
     * @ORM\Column(type="string", length=7, nullable=false, unique=true)
     */
    private $reference;

    /**
     * @var Node The node where this checkin takes place
     *
     * @Groups({"read","write"})
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity=Node::class, inversedBy="checkins")
     * @ORM\JoinColumn(nullable=false)
     */
    private $node;

    /**
     * @var string The contact details of this checkin
     *
     * @example https://example.org/people/1
     *
     * @Groups({"read","write"})
     * @Assert\Url
     * @Assert\NotNull
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $person;

    /**
     * @var string The user that dit the check
     *
     * @example https://example.org/users/1
     *
     * @Groups({"read","write"})
     * @Assert\Url
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userUrl;

    /**
     * @var DateTime The moment this check-in ended by leaving the node
     *
     * @example 20190101
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCheckedOut;

     * @var DateTime The moment this object will be archived
    /**
     *
     * @example 20190101
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateToArchive;

    /**
     * @var DateTime The moment this request was created by the submitter
     *
     * @example 20190101
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var DateTime The moment this request was created by the submitter
     *
     * @example 20190101
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

    public function getDateToArchive(): ?DateTimeInterface
    {
        return $this->dateToArchive;
    }

    public function setDateArchive(DateTimeInterface $dateToArchive): self
    {
        $this->dateToArchive = $dateToArchive;

        return $this;
    }

    /**
     *  @ORM\PrePersist
     *  @ORM\PreUpdate
     *
     *  */
    public function prePersist()
    {
        // If no reference has been provided we want to make one
        if (!$this->getReference()) {
            $validChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $part1 = substr(str_shuffle(str_repeat($validChars, ceil(3 / strlen($validChars)))), 1, 3);
            $part2 = substr(str_shuffle(str_repeat($validChars, ceil(3 / strlen($validChars)))), 1, 3);

            $reference = $part1.'-'.$part2;
            $this->setReference($reference);
        }

        $this->createDateToArchive();
    }

    public function createDateToArchive()
    {
        $date = new DateTime('today');
        $date->add(new DateInterval('P14D'));

        $this->setDateToArchive($date);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getNode(): ?Node
    {
        return $this->node;
    }

    public function setNode(?Node $node): self
    {
        $this->node = $node;

        return $this;
    }

    public function getPerson(): ?string
    {
        return $this->person;
    }

    public function setPerson(string $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getUserUrl(): ?string
    {
        return $this->userUrl;
    }

    public function setUserUrl(string $userUrl): self
    {
        $this->userUrl = $userUrl;

        return $this;
    }

    public function getDateCheckedOut(): ?DateTimeInterface
    {
        return $this->dateCheckedOut;
    }

    public function setDateCheckedOut(DateTimeInterface $dateCheckedOut): self
    {
        $this->dateCheckedOut = $dateCheckedOut;

        return $this;
    }

    public function getDateToDestory(): ?DateTimeInterface
    {
        return $this->dateToDestory;
    }

    public function getDateCreated(): ?DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }
}
