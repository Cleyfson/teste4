# Laravel Microservices Breakdown — kinghost-test App

## Phase 0: Preparation (1–2 Days)
- [ ] Review monolith modules: Auth, Favorites, Movies
- [ ] Draw service-diagram (modules, data ownership)
- [ ] Note shared vs independent logic

## Phase 1: Design Services (3–5 Days)
- [ ] Define service list:
    - AuthService (login/register/JWT)
    - MovieService (TMDB integration)
    - FavoriteService (favorite CRUD)
    - API Gateway
- [ ] Sketch inter-service API contracts
- [ ] Choose first MVP service (FavoriteService)

## Phase 2: Extract FavoriteService (5–10 Days)
- [ ] Create new Laravel app: `favorite-service`
- [ ] Copy `FavoriteController`, Domain, UseCases, Repo, Routes
- [ ] Create migration for `favorites` (+ foreign key to `user_id`)
- [ ] Define REST API: GET, POST, DELETE
- [ ] Implement JWT auth middleware
- [ ] Update frontend to call this endpoint
- [ ] Add Dockerfile + docker-compose override

## Phase 3: Extract MovieService + AuthService (1–2 Weeks)
- [ ] MovieService:
    - Copy TMDB-related controllers/services
    - Add caching layer
    - Implement REST endpoints
- [ ] AuthService:
    - Copy Login/Register & JWT generation
    - Add migrations, user model
    - Secure endpoints
    - Adjust frontend login flow

## Phase 4: Local Orchestration (3–5 Days)
- [ ] Create `docker-compose.yml` for all services
- [ ] Add nginx or API Gateway container
- [ ] Set distinct ports for each service
- [ ] Configure CORS and environment files
- [ ] Implement centralized logging (stdout or Sentry)

## Phase 5: AWS Deployment (2–3 Weeks)
- [ ] Provision AWS resources:
    - ECS (Fargate) or EC2 for each service
    - RDS for each DB
    - S3 for static assets
    - Secrets Manager / SSM
- [ ] Containerize and push to ECR
- [ ] Deploy FavoriteService first
- [ ] Test using Postman or frontend

## Phase 6: CI/CD & Monitoring (1–2 Weeks)
- [ ] Setup GitHub Actions CI workflows
- [ ] Automate build, push (to ECR), deploy
- [ ] Add logging/monitoring:
    - CloudWatch, X‑Ray, Sentry

## Phase 7: Advanced Features (Ongoing)
- [ ] Add async messaging via SQS/SNS
- [ ] Implement retry, timeout, fallback patterns
- [ ] Build gateway (Traefik, Kong, or Laravel)
- [ ] Document APIs (Swagger/Postman)
- [ ] Add observability dashboards (Grafana, Prometheus)
