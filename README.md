```markdown
# Real-Time Bidding System

This is a Laravel-based backend for a Real-Time Bidding (RTB) System, built with Laravel 10, MySQL, Redis, and Docker. The system supports user authentication, ad slot management, bid placement, and automatic bid evaluation using Laravel Queues and Scheduler.

## Features
- User authentication with Laravel Sanctum
- Ad slot management (create, list with filters)
- Bid placement with queue processing
- Automatic ad slot status updates and bid evaluation
- API endpoints for all required operations
- Containerized with Docker

## Setup Instructions

### Prerequisites
- Docker and Docker Compose
- Git
- Composer (optional, for local development without Docker)

### Installation
1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd rtb-system
   ```

2. Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```

3. Generate an application key:
   ```bash
   docker-compose exec app php artisan key:generate
   ```

4. Start the Docker containers:
   ```bash
   docker-compose up -d
   ```

5. Run migrations and seed the database:
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

6. Start the queue worker:
   ```bash
   docker-compose exec app php artisan queue:work
   ```

7. Run the scheduler:
   ```bash
   docker-compose exec app php artisan schedule:run
   ```

   To run the scheduler continuously, use:
   ```bash
   docker-compose exec app php artisan schedule:work
   ```

### Running the Application
- The application will be available at `http://localhost:8000`.
- API endpoints are prefixed with `/api`.

### Sample User Credentials
- Admin: `admin@gmail.com` / `password`
- User: `user@gmail.com` / `password`

## API Endpoints
- **POST /api/login**: Authenticate and get token
- **GET /api/ad-slots**: List ad slots (filter by status: ?status=upcoming,open,closed,awarded)
- **POST /api/ad-slots**: Create a new ad slot (admin only)
- **POST /api/ad-slots/{id}/bids**: Place a bid
- **GET /api/ad-slots/{id}/bids**: View all bids for a slot
- **GET /api/ad-slots/{id}/winner**: View the winning bid
- **GET /api/bids**: View user's bidding history

## Approach
- **Authentication**: Uses Laravel Sanctum for token-based authentication.
- **Ad Slot Management**: Ad slots are managed with a model and status updates are handled via a scheduled command (`adslot:update-status`).
- **Bid Placement**: Bids are processed asynchronously using Laravel Queues (Redis) to handle concurrent submissions.
- **Bid Evaluation**: A scheduled command (`bids:evaluate`) runs every minute to evaluate closed slots and select winners based on highest bid (earliest in case of ties).
- **Docker**: The app, MySQL, and Redis are containerized for consistent development and deployment.

## Notes
- The queue worker and scheduler must be running for bid processing and status updates/evaluation to work.
- Sample data is seeded for testing (users and ad slots).
- The system uses Redis for queue management to ensure scalability.
```

## Explanation of Approach
- **Authentication**: Laravel Sanctum is used for simple token-based authentication, suitable for API-driven applications.
- **Ad Slot Management**: The `AdSlot` model handles slot details, with a scheduled command (`UpdateAdSlotStatus`) updating statuses based on time.
- **Bid Placement**: Bids are processed via a `ProcessBid` job to handle concurrency, ensuring reliable storage in the database.
- **Bid Evaluation**: The `EvaluateBids` command runs every minute to process closed slots, selecting the highest (and earliest in case of ties) bid as the winner.
- **Database**: MySQL is used with foreign key constraints for data integrity. The `bid_winners` table logs winning bids.
- **Docker**: The app is containerized with PHP, MySQL, and Redis for easy setup and consistent environments.
- **API**: All required endpoints are implemented with proper validation and error handling.

This solution meets all requirements, follows Laravel best practices, and is ready to run in a Dockerized environment. The README provides clear instructions for setup and usage.