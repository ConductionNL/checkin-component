<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * An entity representing an node.
 *
 * A node being a point where users can check in as part of a place
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
 *              "path"="/nodes/{id}/change_log",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Changelogs",
 *                  "description"="Gets al the change logs for this resource"
 *              }
 *          },
 *          "get_audit_trail"={
 *              "path"="/nodes/{id}/audit_trail",
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
 * @ORM\Entity(repositoryClass=App\Repository\NodeRepository::class)
 * @Gedmo\Loggable(logEntryClass="Conduction\CommonGroundBundle\Entity\ChangeLog")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="node_reference", columns={"reference"})})
 *
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(DateFilter::class, strategy=DateFilter::EXCLUDE_NULL)
 * @ApiFilter(SearchFilter::class, properties={
 *     "accommodation": "exact",
 *     "event": "exact",
 *     "reference": "iexact",
 *     "type": "exact",
 *     "organization": "partial",
 *     "name": "partial",
 *     "description": "partial"})
 */
class Node
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
     * @var string The type of this node
     *
     * @example checkin
     *
     * @Gedmo\Versioned
     * @Assert\Choice({"checkin", "reservation", "clockin", "mailing"})
     * @Assert\Length(
     *      max = 255
     * )
     *
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=12)
     */
    private $type = 'checkin';

    /**
     * @var string The name of the invoice
     *
     * @Gedmo\Versioned
     *
     * @example My Invoice
     * @Groups({"read","write"})
     * @Assert\Length(
     *     max=255
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string The description of the invoice
     *
     * @Gedmo\Versioned
     *
     * @example This is the best invoice ever
     * @Groups({"read","write"})
     * @Assert\Length(
     *     max=255
     * )
     * @ORM\Column(type="string", length=2550, nullable=true)
     */
    private $description;

    /**
     * @var string The Accommodation of this node
     *
     * @example https://example.org/accomodations/1
     *
     * @Groups({"read","write"})
     * @Assert\Url
     * @Assert\NotNull
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $accommodation;

    /**
     * @var string The Event of this node
     *
     * @example https://example.org./api/v1/arc/events/id
     *
     * @Groups({"read","write"})
     * @Assert\Url
     * @Assert\NotNull
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $event;

    /**
     * @var string The organization that ownes this node
     *
     * @example https://example.org/organizations/1
     *
     * @Groups({"read","write"})
     * @Assert\Url
     * @Assert\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $organization;

    /**
     * @var string The url to a page of the organization of this node
     *
     * @example https://example.org/succesful-checkin
     *
     * @Groups({"read","write"})
     * @Assert\Url
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $passthroughUrl;

    /**
     * @ORM\OneToMany(targetEntity=Checkin::class, mappedBy="node", orphanRemoval=true)
     */
    private $checkins;

    /**
     * @var array the authentication methods this node supports
     *
     * @example Idin, Gmail, Facebook
     *
     * @Gedmo\Versioned
     * @Groups({"read","write"})
     * @ORM\Column(type="json")
     */
    private $methods = [];

    /**
     * The QR code options for this node as defined by endroid/qr-code-bundle.
     *
     * @Gedmo\Versioned
     * @Groups({"read","write"})
     * @ORM\Column(type="json")
     */
    private $qrConfig = [];

    /**
     * @var DateInterval The standard duration of a check-in
     *
     * @example P3Y6M4DT12H30M5S
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="dateinterval", nullable=true)
     */
    private $checkinDuration;

    /**
     * @var DateTime The moment all check-ins are forced to end
     *
     * @example 08:00
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="time", nullable=true)
     */
    private $checkoutTime;

    /**
     * @Gedmo\Versioned
     * @Groups({"read","write"})
     * @ORM\Column(type="json")
     */
    private $configuration = [];

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

    public function __construct()
    {
        $this->checkins = new ArrayCollection();
    }

    /**
     *  @ORM\PrePersist
     *  @ORM\PreUpdate
     *
     *  */
    public function prePersist()
    {
        if (!$this->getReference()) {
            $validChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $part1 = substr(str_shuffle(str_repeat($validChars, ceil(3 / strlen($validChars)))), 1, 3);
            $part2 = substr(str_shuffle(str_repeat($validChars, ceil(3 / strlen($validChars)))), 1, 3);

            $reference = $part1.'-'.$part2;
            $this->setReference($reference);
        }
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAccommodation(): ?string
    {
        return $this->accommodation;
    }

    public function setAccommodation(string $accommodation): self
    {
        $this->accommodation = $accommodation;

        return $this;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(string $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(string $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getPassthroughUrl(): ?string
    {
        return $this->passthroughUrl;
    }

    public function setPassthroughUrl(string $passthroughUrl): self
    {
        $this->passthroughUrl = $passthroughUrl;

        return $this;
    }

    /**
     * @return Collection|Checkin[]
     */
    public function getCheckins(): Collection
    {
        return $this->checkins;
    }

    public function addCheckin(Checkin $checkin): self
    {
        if (!$this->checkins->contains($checkin)) {
            $this->checkins[] = $checkin;
            $checkin->setNode($this);
        }

        return $this;
    }

    public function removeCheckin(Checkin $checkin): self
    {
        if ($this->checkins->contains($checkin)) {
            $this->checkins->removeElement($checkin);
            // set the owning side to null (unless already changed)
            if ($checkin->getNode() === $this) {
                $checkin->setNode(null);
            }
        }

        return $this;
    }

    public function getMethods(): ?array
    {
        return $this->methods;
    }

    public function setMethods(array $methods): self
    {
        $this->methods = $methods;

        return $this;
    }

    public function getQrConfig(): ?array
    {
        return $this->qrConfig;
    }

    public function setQrConfig(array $qrConfig): self
    {
        $this->qrConfig = $qrConfig;

        return $this;
    }

    public function getConfiguration(): ?array
    {
        return $this->configuration;
    }

    public function setConfiguration(array $configuration): self
    {
        $this->configuration = $configuration;

        return $this;
    }

    public function getCheckinDuration(): ?\DateInterval
    {
        return $this->checkinDuration;
    }

    public function setCheckinDuration(\DateInterval $checkinDuration): self
    {
        $this->checkinDuration = $checkinDuration;

        return $this;
    }

    public function getCheckoutTime(): ?\DateTimeInterface
    {
        return $this->checkoutTime;
    }

    public function setCheckoutTime(\DateTimeInterface $checkoutTime): self
    {
        $this->checkoutTime = $checkoutTime;

        return $this;
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
