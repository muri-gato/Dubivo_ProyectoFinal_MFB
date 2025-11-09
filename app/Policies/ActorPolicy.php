// app/Policies/ActorPolicy.php
public function update(User $user, Actor $actor)
{
    return $user->id === $actor->user_id || $user->isAdmin();
}

public function delete(User $user, Actor $actor)
{
    return $user->id === $actor->user_id || $user->isAdmin();
}