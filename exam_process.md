# CBT Examination Process Overview

The Computer-Based Test (CBT) platform is designed for secure offline examination environments where each examination centre operates independently. Every examination centre is equipped with a dedicated **Primary Server** and a **Backup Server**, supporting up to **200 candidates**. If additional capacity is required, another independent server pair is deployed rather than horizontally scaling the existing server.

Candidate workstations are connected only through a secured Local Area Network (LAN) and do not have Internet access during the examination. Each workstation runs the Exam Launcher, which restricts operating system access, disables unauthorized keyboard shortcuts, prevents application switching, and does not allow candidates to exit the examination without administrator authorization or a secure unlock key.

## Deployment Architecture

* One Primary Server supports up to 200 candidates.
* One Backup Server continuously synchronizes examination data from the Primary Server at regular intervals (approximately every 20 seconds).
* Each server pair operates independently and maintains its own examination database, logs, and backups.
* If a venue requires support for more than 200 candidates, additional Primary–Backup server pairs are deployed.

## Examination Lifecycle

### 1. Drive Preparation (Head Office)

Before the examination day, the Head Office (HQ) prepares the examination drive by:

* Creating the examination drive.
* Importing candidate information.
* Importing question papers.
* Assigning predefined question paper sets (A/B/C/D) or configured question sequences.
* Encrypting and packaging all examination resources.
* Generating a downloadable examination package.

Question paper shuffling and assignment are performed centrally at HQ to ensure consistency across all examination centres and to simplify auditing.

### 2. Drive Download

Before the examination begins, each examination centre downloads the encrypted examination package from HQ.

The downloaded package includes:

* Candidate database
* Question papers
* Examination configuration
* Drive metadata
* Required examination resources

The package is imported into the local examination server and synchronized to the Backup Server.

### 3. Pre-Exam Verification

Prior to the examination, administrators verify:

* Successful drive import.
* Candidate availability.
* Primary and Backup server synchronization.
* LAN connectivity for all candidate systems.
* Launcher availability on every workstation.
* System readiness.

Only after successful verification is the examination marked as ready.

### 4. Examination Start

At the scheduled time, the administrator starts the examination.

Once started:

* Candidate login is enabled.
* Examination timer begins.
* Question papers become accessible.
* Candidate responses begin to be recorded.

### 5. Examination in Progress

During the examination:

* Candidate responses are automatically saved.
* All answer logs are stored on the Primary Server.
* Incremental synchronization to the Backup Server occurs at regular intervals.
* System events and audit logs are continuously recorded.
* Candidate machines communicate only with the local examination server through the secured LAN.

Since the examination operates entirely offline, Internet connectivity is not required during the examination.

### 6. Examination Completion

The examination ends either when:

* The allotted examination time expires, or
* The candidate submits the examination manually.

Once completed:

* Further modifications to responses are prevented.
* Final answer data is stored.
* Examination statistics and logs are finalized.

### 7. Backup

After completion, the system generates a complete examination backup containing:

* Candidate responses
* Examination logs
* Audit logs
* Database backup
* Examination metadata

This backup serves as the official centre copy for recovery and auditing purposes.

### 8. Result Upload

Once Internet connectivity is available, the examination centre uploads the encrypted examination package back to HQ.

The uploaded package includes:

* Candidate responses
* Examination logs
* Audit logs
* Backup files
* Supporting metadata

HQ verifies the uploaded package before importing responses into the central examination database for evaluation and result processing.

## Design Considerations

* Offline-first architecture with no Internet dependency during examinations.
* Independent server pairs eliminate the need for horizontal scaling within a centre.
* Backup Server provides disaster recovery through periodic synchronization.
* LAN-only communication minimizes security risks.
* Centralized question paper preparation and shuffling ensure consistency and simplify auditing.
* Exam Launcher enforces a controlled examination environment by restricting operating system access and unauthorized actions.
