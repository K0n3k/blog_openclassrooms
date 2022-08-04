<?php

namespace App\Enums;

enum Toasts {
    case AllFieldsMustBeFilled;
    case CommentaryCreated;
    case CommentaryDeleted;
    case CommentaryUnValidated;
    case CommentaryValidated;
    case EmailAllreadyUsed;
    case EmailSuccefullySended;
    case IncorrectEmailOrPassword;
    case PostCreated;
    case PostDeleted;
    case PostFieldsEmpty;
    case PostModified;
    case PostPublished;
    case PostUnPublished;
    case UserConnected;
    case UserCreated;
    case UserDeleted;
    case UserDisconnected;
    case UserFieldsEmpty;
    case UserIsAdmin;
    case UserIsNotAdmin;
    case UserModified;
}