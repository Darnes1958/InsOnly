<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MainResource\Pages;
use App\Filament\Resources\MainResource\RelationManagers;
use App\Models\Main;
use App\Models\Main_arc;
use App\Models\Salary;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;


class MainResource extends Resource
{
    protected static ?string $model = Main::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $pluralModelLabel='عقود';
    protected static ?int $navigationSort = 1;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('رقم العقد')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->unique(table: Main_arc::class)
                    ->default(Main::max('id')+1)
                    ->autofocus()
                    ->numeric()
                   ->columnSpan(2),
               TextInput::make('name')
                    ->label('الزبون')
                    ->required()
                    ->columnSpan(2),


                Select::make('bank_id')
                    ->label('المصرف')
                    ->relationship('Bank','BankName')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\Section::make('ادخال مصارف')
                            ->description('ادخال بيانات مصرف .. ويمكن ادخال المصرف التجميعي اذا كان غير موجود بالقائمة')
                            ->schema([
                                TextInput::make('BankName')
                                    ->required()
                                    ->label('اسم المصرف')
                                    ->maxLength(255),
                                Select::make('taj_id')
                                    ->relationship('Taj','TajName')
                                    ->label('المصرف التجميعي')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('TajName')
                                            ->required()

                                            ->label('المصرف التجميعي')
                                            ->maxLength(255),
                                        TextInput::make('TajAcc')
                                            ->label('رقم الحساب')
                                            ->required(),
                                    ])
                                    ->required(),
                            ])
                    ])
                    ->editOptionForm([
                        Forms\Components\Section::make('ادخال مصارف')
                            ->description('ادخال بيانات مصرف .. ويمكن ادخال المصرف التجميعي اذا كان غير موجود بالقائمة')
                            ->schema([
                                TextInput::make('BankName')
                                    ->required()
                                    ->label('اسم المصرف')
                                    ->maxLength(255),
                                Select::make('taj_id')
                                    ->relationship('Taj','TajName')
                                    ->label('المصرف التجميعي')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('TajName')
                                            ->required()

                                            ->label('المصرف التجميعي')
                                            ->maxLength(255),
                                        TextInput::make('TajAcc')
                                            ->label('رقم الحساب')
                                            ->required(),
                                    ])
                                    ->required(),
                            ])


                    ])
                    ->createOptionAction(fn ($action) => $action->color('success'))
                    ->editOptionAction(fn ($action) => $action->color('info'))
                    ->required(),

                TextInput::make('acc')
                    ->label('رقم الحساب')
                    ->required(),

                DatePicker::make('sul_begin')
                    ->required()
                    ->label('تاريخ العقد')
                    ->maxDate(now())
                    ->default(now()),
                TextInput::make('kst')
                    ->label('القسط')
                    ->required(),
                Select::make('sell_id')
                    ->label('نوع الخدمة')
                    ->relationship('Sell','item_name')
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\Section::make('ادخال نوع خدمة')
                            ->description('ادخال نوع خدمة او منتج للتقسيط')
                            ->schema([
                                TextInput::make('item_name')
                                    ->required()
                                    ->label('إسم الخدمة او المنتج')
                                    ->maxLength(255),
                            ])
                            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                $data['user_id'] = auth()->id();

                                return $data;
                            })
                    ])
                    ->editOptionForm([
                        Forms\Components\Section::make('تعديل اسم منتج')
                            ->description('تعديل اسم المنتج أو الخدمة المقسطة')
                            ->schema([
                                TextInput::make('item_name')
                                    ->required()
                                    ->label('اسم الخدمة أو المنتج')
                                    ->maxLength(255),
                            ])
                    ])
                    ->createOptionAction(fn ($action) => $action->color('success'))
                    ->editOptionAction(fn ($action) => $action->color('info'))

                    ->required()

                    ->columnSpan(2),
                TextInput::make('notes')
                    ->label('ملاحظات')->columnSpanFull(),

                                TextInput::make('address')
                                    ->label('العنوان'),
                                TextInput::make('mdar')
                                    ->label('مدار'),
                                TextInput::make('libyana')
                                    ->label('لبيانا'),
                                TextInput::make('card_no')
                                    ->label('رقم الهوية'),
                                TextInput::make('nat_id')
                                    ->label('الرقم الوطني'),

            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم')->searchable()->sortable(),
                TextColumn::make('Bank.BankName')->label('المصرف')->searchable()->sortable(),
                TextColumn::make('acc')->label('رقم الحساب')->searchable()->sortable(),
                TextColumn::make('kst')->label('القسط'),
                TextColumn::make('tran_sum_ksm')
                ->label('إجمالي الاقساط المخصومة')
                ->sum('Tran','ksm')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('print')
                    ->hiddenLabel()
                    ->iconButton()->color('success')
                    ->icon('heroicon-m-printer')
                    ->url(fn (Main $record): string => route('pdfmaincont', $record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMains::route('/'),
            'create' => Pages\CreateMain::route('/create'),
            'edit' => Pages\EditMain::route('/{record}/edit'),
        ];
    }
}
